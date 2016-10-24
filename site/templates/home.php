<form action="deploy" id="createEmail" name="createEmail" method="get">

<!--
		The value of "service" will choose which folders to get the HTML from,
		allowing you to override the default templates with specific ones in
		certain situations. If the specific "service" value doesn't have an
		override template, it should use the default one by default. This works
		for custom headers, footers or body contents on an individual basis. So
		you can have a custom header and body, but use the default footer by
		simply not including a custom footer file.
-->
<input type="hidden" name="service" id="service" value="app1" />

<!--
		The value of "event" determines which "content" HTML file to get. In
		this case, it's looking for the "account-created" event file located
		at "content/emails/content/default/account-created" that actually only
		has basic formatting and a %message% variable that adds the content of
		the "personalized_message" field from this form.
-->
<input type="hidden" name="event" id="event" value="account-created" />


<label for="recipient_email">Recipient's Email:</label><br/>
<input type="email" name="recipient_email" id="recipient_email" required><br/><br/>

<label for="recipient_firstname">Recipient's First Name:</label><br/>
<input type="text" name="recipient_firstname" id="recipient_firstname" required value="Recipient"><br/><br/>

<label for="recipient_lastname">Recipient's Last Name:</label><br/>
<input type="text" name="recipient_lastname" id="recipient_lastname" required value="Jones"><br/><br/>

<label for="sender_email">Sender's Email:</label><br/>
<input type="email" name="sender_email" id="sender_email" required value="noreply@noreply.com"><br/><br/>

<label for="sender_firstname">Sender's First Name:</label><br/>
<input type="text" name="sender_firstname" id="sender_firstname" required value="Thomas"><br/><br/>

<label for="sender_lastname">Sender's Last Name:</label><br/>
<input type="text" name="sender_lastname" id="sender_lastname" required value="Sender"><br/><br/>

<label for="personalized_message">Personalized Message:</label><br/>
<textarea name="personalized_message" id="personalized_message" required>This is a custom message that will appear in the body of the e-mail.</textarea><br/><br/>

<input type="submit" value="Send Email" />

</form>