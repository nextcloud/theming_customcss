# Custom CSS: customize your CSS to better fit your Theming needs

Allow admins to add custom CSS to their Nextcloud instance from inside the Theming settings.

![](https://github.com/juliushaertl/theming_customcss/raw/master/screenshot.png)

## Use theming color values

Admin can use CSS custom properties to make use of the variables that are available from the [default.css variables file](https://github.com/nextcloud/server/blob/master/apps/theming/css/default.css) file:

Example:

```
#element {
  color: var(--color-primary);
}
```

## *How can I recover if my customized CSS code has broken the user interface?*

The css configuration is stored in the app config database table, but you can use the `occ config:app:*` commands to obtain, modify or reset it as well. e.g.

```
occ config:app:get theming_customcss customcss
occ config:app:set theming_customcss customcss --value "body { background-color: red; }"
occ config:app:delete theming_customcss customcss
```
## Usage via occ command

Examples:

```
occ config:app:get theming_customcss customcss
occ config:app:set theming_customcss customcss --value "body { background-color: red; }"
occ config:app:delete theming_customcss customcss
```

Note:

- if you want to do a lot of settings, make sure to use minimized CSS and that the first and last quote are single quotes, for example:
```
occ config:app:set theming_customcss customcss --value '
#contactsmenu{display:none}#help{display:none}.app-navigation-personal li[data-section-id="availability"]{display:none}.app-navigation-personal li[data-section-id="workflow"]{display:none}.app-navigation-administration li[data-section-id="admindelegation"]{display:none}.section-emails>div>.button-vue{display:none}#personal-settings :nth-child(5){display:none}#personal-settings :nth-child(7){display:none}#personal-settings :nth-child(8){display:none}#personal-settings :nth-child(9){display:none}#personal-settings :nth-child(12){display:none}#personal-settings :nth-child(13){display:none}#personal-settings :nth-child(14){display:none}#personal-settings :nth-child(15){display:none}#personal-settings :nth-child(16){display:none}#personal-settings :nth-child(17){display:none}.section-emails>div>.federation-actions{display:none}#personal-settings :nth-child(4) .federation-actions{display:none}#personal-settings :nth-child(2) .federation-actions{display:none}#settings-section_default-settings{display:none}#new-user-form :nth-child(7){display:none}#new-user-form .dialog__managers{display:none}.user-list__header [data-cy-user-list-header-subadmins]{display:none!important}.user-list__body [data-cy-user-list-cell-subadmins]{display:none!important}.user-list__header [data-cy-user-list-header-manager]{display:none!important}.user-list__body [data-cy-user-list-cell-manager]{display:none!important}:root{--header-menu-icon-mask:linear-gradient()!important}
'
```
