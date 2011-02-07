## Installation

First download mbForms from https://github.com/snsmurf/mbForms
Once downloaded, create a folder within the WolfCMS plugins folder (default will be /wolf/plugins/) called 'mbforms' then unzip the contents of the download into this folder.

Next login to the admin area of your WolfCMS installation and navigate to the the plugin list found under the Administration tab. Once there, just check the enable box next to mbForms. This will run the installation which will setup the MySQL for you.

## Using mbForms

To start using mbForms, navigate to the new 'Form Builder' tab which should now appear at the top of your admin (if it's not there, please check you have installed it correctly).

Once on the main mbForms admin page, use the button in the right sidebar (Create Form) to create a new form. Fill the form in, remember to take note of your form name as this is used later on to display the form.
Once the first bit has been filled in use the 'Add Item' link to add items to your form.

Once you've setup your form, you are now ready to add the form to your page. Click the pages tab in the admin to bring up your list of pages. Edit the page you wish the form to appear on and then add the following code, substituting FORMNAME for the form name you entered earlier.

&lt;?php mbForm('FORMNAME'); ?&gt;

## Captcha

mbForms uses reCaptcha for it's spam bot catching! In order to use the captcha functionality in mbForms you'll need to create some reCaptcha keys and place these in the mbForms settings. To generate your public/private keys for reCaptcha visit the follow link.
https://www.google.com/recaptcha/admin/create

## Support

While I will attempt to provide support as much as possible, this is only a hobby project so I don't have all the time in the world to maintain the script and update it as much as I would like.
If you appreciate what I do then and would like give a donation then that would be most welcome and can be done via the paypal button in the right menu at www.mikebarlow.co.uk.
