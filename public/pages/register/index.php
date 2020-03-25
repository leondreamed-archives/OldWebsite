<meta name="google-signin-client_id" content="445196061842-ken4euge6vjm7oe895genvfbqlb655be.apps.googleusercontent.com" />
<script src="https://apis.google.com/js/platform.js" async defer></script>
<div class="account-box">
  <div class="account-box-title">Register</div>
  <div class="account-box-section">
    Username
    <input type="text" />
  </div>
  <div class="account-box-section">
    Email
    <input type="text" />
  </div>
  <div class="account-box-section">
    Password
    <input type="password" />
  </div>
  <div class="account-box-section">
    Confirm Password
    <input type="password" />
  </div>
  <div class="g-signin2" data-onsuccess="onSignIn"></div>
</div>
<script>
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
</script>
