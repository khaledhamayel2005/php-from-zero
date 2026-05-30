
htmlspecialchars(): converts dangerous HTML characters into safe HTML entities.
By default htmlspecialchars() only escapes double quotes ".
Adding ENT_QUOTES tells it to also escape single quotes ':

$input = "It's a \"test\" <script>alert('hack')</script>";

// WITHOUT ENT_QUOTES
echo htmlspecialchars($input);
// It's a &quot;test&quot; &lt;script&gt;alert('hack')&lt;/script&gt;
// Note: single quote NOT escaped - still dangerous!

// WITH ENT_QUOTES
echo htmlspecialchars($input, ENT_QUOTES);
// It&#039;s a &quot;test&quot; &lt;script&gt;alert(&#039;hack&#039;)&lt;/script&gt;
// Note: both quotes escaped - safe!
