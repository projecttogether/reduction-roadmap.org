#!/bin/bash

set -u

app_dir=/var/www/html
ssh_dir=/var/www/.ssh
git_content_ready_file=/run/git-content-ready
repository_url=${GIT_REPOSITORY_URL:-git@github.com:projecttogether/reduction-roadmap.org.git}
repository_branch=${GIT_BRANCH:-${COOLIFY_BRANCH:-devel}}
git_ssh_command="ssh -o BatchMode=yes -o ConnectTimeout=10 -o ConnectionAttempts=1 -o UserKnownHostsFile=$ssh_dir/known_hosts"

# The plugin stays disabled until the repository is fully usable. /run is
# container-local, so a failed or restarted initialization cannot leave a
# stale success marker behind.
rm -f "$git_content_ready_file"

# Write the deploy key supplied by Coolify for Git Content pull/push access.
if [ -n "${GIT_DEPLOY_KEY:-}" ]; then
    printf '%s\n' "$GIT_DEPLOY_KEY" > "$ssh_dir/id_ed25519"
    chmod 600 "$ssh_dir/id_ed25519"
    chown www-data:www-data "$ssh_dir/id_ed25519"
    git_ssh_command="$git_ssh_command -i $ssh_dir/id_ed25519 -o IdentitiesOnly=yes"
elif [[ "$repository_url" == git@* || "$repository_url" == ssh://* ]]; then
    echo "WARNING: GIT_DEPLOY_KEY is not set; an SSH Git remote will reject private repository access." >&2
fi

export GIT_SSH_COMMAND="$git_ssh_command"
unset GIT_DEPLOY_KEY

initialize_repository() {
    if ! git -C "$app_dir" rev-parse --is-inside-work-tree >/dev/null 2>&1; then
        git -C "$app_dir" init --initial-branch="$repository_branch" || return 1
    fi

    if git -C "$app_dir" remote get-url origin >/dev/null 2>&1; then
        git -C "$app_dir" remote set-url origin "$repository_url" || return 1
    else
        git -C "$app_dir" remote add origin "$repository_url" || return 1
    fi

    timeout 60s git -C "$app_dir" fetch --depth=50 origin "$repository_branch" || return 1

    # Coolify's Docker build context does not reliably include .git. Rebuild
    # the index and branch metadata without overwriting persisted content.
    if git -C "$app_dir" rev-parse --verify HEAD >/dev/null 2>&1; then
        deployed_head=$(git -C "$app_dir" rev-parse HEAD) || return 1
    else
        deployed_head=$(git -C "$app_dir" rev-parse "origin/$repository_branch") || return 1
    fi

    git -C "$app_dir" update-ref "refs/heads/$repository_branch" "$deployed_head" || return 1
    git -C "$app_dir" symbolic-ref HEAD "refs/heads/$repository_branch" || return 1
    git -C "$app_dir" reset --mixed HEAD || return 1
    git -C "$app_dir" branch --set-upstream-to="origin/$repository_branch" "$repository_branch" || return 1
    chown -R www-data:www-data "$app_dir/.git" || return 1
    touch "$git_content_ready_file" || return 1
}

# Repository setup can depend on an external SSH service. It must never delay
# Apache or make the public website fail its proxy health check.
(
    if ! initialize_repository; then
        echo "WARNING: Git Content repository initialization failed; the website is available, but Git Content is disabled until the connection is fixed." >&2
    fi
) &

exec apache2-foreground
