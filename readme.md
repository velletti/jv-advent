archived Version running with LTS 11

will be adjusted to run with V12 or 13 when needed

## Frontend user ViewHelper

Register the namespace and assign the result to a Fluid variable:

```html
{namespace advent=Jvelletti\JvAdvent\ViewHelper}
<f:variable name="user" value="{advent:feUser(uid: userUid)}" />
{user.firstname} {user.lastname}
```

The result contains `username`, `imagesrc`, `firstname` and `lastname`.
`username` is `null` when it equals the email address, and `imagesrc` is
`null` when no image exists. Missing, disabled, deleted or otherwise
unavailable users produce an empty array.
