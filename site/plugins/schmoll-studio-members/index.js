/**
 * Panel preview for the "Mitglieder-Wand" block.
 *
 * Kirby renders a block with the component k-block-type-<type> when one is
 * registered, so registering "members-wall" here replaces the default field
 * preview with a mockup of the wall.
 *
 * Written as a render function on purpose: the panel runs with
 * vue.compiler => false, so template strings are not compiled at runtime.
 * Block content keys are stored lowercased, hence showlogowall / textwallscope.
 */
(function () {
  "use strict";

  var NAME_WIDTHS = [68, 92, 54, 110, 74, 86, 60, 98, 70, 84, 58, 104];

  panel.plugin("schmoll-studio/members", {
    blocks: {
      "members-wall": {
        computed: {
          headlineText: function () {
            return (this.content.headline || "").trim();
          },
          introText: function () {
            return (this.content.intro || "").trim();
          },
          columnCount: function () {
            var n = parseInt(this.content.columns, 10);
            return n >= 4 && n <= 7 ? n : 6;
          },
          logoWallVisible: function () {
            var v = this.content.showlogowall;
            // unset means "not configured yet", which matches the default
            return v === undefined || v === "" || v === true || v === "true";
          },
          textWallScope: function () {
            return this.content.textwallscope || "without-logo";
          },
          textWallVisible: function () {
            return this.textWallScope !== "none";
          },
          scopeLabel: function () {
            return this.textWallScope === "all"
              ? "Textwand: alle Mitglieder"
              : "Textwand: Mitglieder ohne Logo";
          }
        },
        render: function (h) {
          var self = this;
          var children = [];

          children.push(
            h("div", { class: "members-wall-preview__headline" },
              this.headlineText || "Überschrift")
          );

          if (this.introText) {
            children.push(
              h("div", { class: "members-wall-preview__intro" }, this.introText)
            );
          }

          if (this.logoWallVisible) {
            var cells = [];
            for (var i = 0; i < this.columnCount * 2; i++) {
              cells.push(h("span", { class: "members-wall-preview__logo" }));
            }
            children.push(h("div", { class: "members-wall-preview__rule" }));
            children.push(
              h("div", {
                class: "members-wall-preview__logos",
                style: { gridTemplateColumns: "repeat(" + this.columnCount + ", 1fr)" }
              }, cells)
            );
          }

          if (this.textWallVisible) {
            var bars = NAME_WIDTHS.map(function (w) {
              return h("span", {
                class: "members-wall-preview__name",
                style: { width: w + "px" }
              });
            });
            children.push(h("div", { class: "members-wall-preview__rule" }));
            children.push(h("div", { class: "members-wall-preview__names" }, bars));
          }

          children.push(
            h("div", { class: "members-wall-preview__meta" }, [
              h("span", {}, this.logoWallVisible
                ? "Logowand: " + this.columnCount + " pro Reihe"
                : "Keine Logowand"),
              h("span", {}, self.textWallVisible ? self.scopeLabel : "Keine Textwand")
            ])
          );

          return h("div", { class: "members-wall-preview" }, children);
        }
      }
    }
  });
})();
