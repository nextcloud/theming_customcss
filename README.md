# Custom (S)CSS: customize your CSS to better fit your Theming needs

Allow admins to add custom CSS or SCSS to their Nextcloud instance from inside the Theming settings.

![](https://github.com/juliushaertl/theming_customcss/raw/master/screenshot.png)

## Use theming color values

Admin can use CSS custom properties to make use of the variables that are available from the [default.css variables file](https://github.com/nextcloud/server/blob/master/apps/theming/css/default.css) file:

Example:

```
#element {
  color: var(--color-primary);
}
```

## *How can I recover if my customized CSS or SCSS code has broken the user interface?*

The CSS configuration is stored in the app config database table, but you can use the `occ config:app:*` commands to obtain, modify or reset it as well. e.g.

```
occ config:app:get theming_customcss customcss
occ config:app:set theming_customcss customcss --value "body { background-color: red; }"
occ config:app:delete theming_customcss customcss
```
## Usage via occ command

_Only applies for custom CSS, not SCSS!_

Examples:

```
occ config:app:get theming_customcss customcss
occ config:app:set theming_customcss customcss --value "body { background-color: red; }"
occ config:app:delete theming_customcss customcss
```

Note:

- If your CSS contains single or double quotes, make sure they are properly escaped so the shell does not break the command.

```
occ config:app:set theming_customcss customcss --value '.app-navigation-personal li[data-section-id="workflow"] { display:none } '
```


---

## Third-party code

- `js/vendor/sass.js`, `js/vendor/sass.worker.js` — sass.js by Rodney Rehm,
  MIT License. See js/vendor/LICENSE-sass.js.txt.
- `js/vendor/ace/` — Ace editor by Ajax.org, BSD-3-Clause License.
  See js/vendor/ace/LICENSE.