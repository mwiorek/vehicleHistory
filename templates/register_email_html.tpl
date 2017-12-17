{* Smarty *}

\nContent-type: text/html\r\n\n


<h2>Hello {$name},</h2>
<p>Your account tied to BI-Dashboard has successfully been created. To log on to your account use your email address and your chosen password.</p>
<hr>
<p>If you have not opted in for an account please <a href="http://{$smarty.server.SERVER_NAME}/{$smarty.const.FILENAME_CONTACT_US}">Contact us immediatly</a></p>

--{$email_random_boundary}\r\n\n