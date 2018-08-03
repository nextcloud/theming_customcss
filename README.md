# theming_customcss

Allow admins to add custom css to their nextcloud instance from inside the theming settings.

![](https://github.com/juliushaertl/theming_customcss/raw/master/screenshot.png)

## Use theming color values

With Nextcloud 14 you can use CSS custom properties to make use of the variables that are available from the [css-variables.scss](https://github.com/nextcloud/server/blob/master/core/css/css-variables.scss) file:

Example:

```
#element {
  color: var(--color-primary);
}
```
