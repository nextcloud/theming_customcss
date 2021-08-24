# Custom CSS: customize your CSS to better fit your Theming needs

Allow admins to add custom CSS to their Nextcloud instance from inside the Theming settings.

![](https://github.com/juliushaertl/theming_customcss/raw/master/screenshot.png)

## Use theming color values

Admin can use CSS custom properties to make use of the variables that are available from the [css-variables.scss](https://github.com/nextcloud/server/blob/master/core/css/css-variables.scss) file:

Example:

```
#element {
  color: var(--color-primary);
}
```
