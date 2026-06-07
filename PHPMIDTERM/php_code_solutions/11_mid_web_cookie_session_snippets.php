<?php
/*
Exam: Mid-Web / short PHP code questions
Sources:
- PHPMIDTERM/PDF/Mid-Web_oOtsjef_ok5COFV.pdf
- PHPMIDTERM/PDF/Midterm_oZSMxBm_heiCGfg.pdf
- PHPMIDTERM/PDF/Web_mid_nc2QLqJ_cKt1uav.pdf
- /home/hamail/Downloads/php code forms M.pdf

This file groups short PHP questions that were repeated across the mixed files.
*/

/*
Question:
How do you initiate a PHP session? Then create two session lists for a quiz:
question numbers answered correctly and question numbers answered incorrectly.
*/
session_start();
$_SESSION['correct_questions'] = $_SESSION['correct_questions'] ?? [];
$_SESSION['incorrect_questions'] = $_SESSION['incorrect_questions'] ?? [];

/*
Question:
Write a PHP script that retrieves cookie information from the HTTP request and
stores it in an associative array called $tmp. Use the cookie name as the key
and the cookie value as the value.
*/
$tmp = [];
foreach ($_COOKIE as $cookieName => $cookieValue) {
    // Copy each cookie into a normal associative array.
    $tmp[$cookieName] = $cookieValue;
}

/*
Question:
Write a PHP function that takes two parameters and returns, not echoes, the HTML
for a link. The first parameter is the destination URL and the second parameter
is the link text.
*/
function makeLink(string $url, string $label): string
{
    return '<a href="' . htmlspecialchars($url) . '">'
        . htmlspecialchars($label)
        . '</a>';
}

/*
Question:
Assume a client name is sent to the server using a cookie named clientName.
The cookie should be sent once every 24 hours. A session variable accessCount
stores page access count. Increment the counter. If first visit or cookie is
missing, show a form to enter the name and reset the counter. Otherwise display:
"Dear Fulan, during the last 24 hours this is your 5th visit."
*/
function handleClientVisitCounter(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clientName'])) {
        $clientName = trim($_POST['clientName']);
        $_SESSION['accessCount'] = 0;
        setcookie('clientName', $clientName, time() + 24 * 60 * 60, '/');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (!isset($_COOKIE['clientName'])) {
        // First visit: ask for the client name.
        echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">';
        echo '<label>Your name: <input type="text" name="clientName" required></label>';
        echo '<button type="submit">Save</button>';
        echo '</form>';
        return;
    }

    $_SESSION['accessCount'] = ($_SESSION['accessCount'] ?? 0) + 1;

    echo 'Dear ' . htmlspecialchars($_COOKIE['clientName'])
        . ', during the last 24 hours this is your '
        . htmlspecialchars((string) $_SESSION['accessCount'])
        . 'th visit.';
}

/*
Question:
Given a form that sends FirstName, LastName, and a hidden field named
information with value "secret message" to reply.php, what will reply.php
display if the browser fields are John and Smith?

Answer:
John Smith secret message
*/
function replyHiddenFieldExample(): string
{
    $firstName = $_POST['FirstName'] ?? 'John';
    $lastName = $_POST['LastName'] ?? 'Smith';
    $message = $_POST['information'] ?? 'secret message';

    return htmlspecialchars($firstName . ' ' . $lastName . ' ' . $message);
}

/*
Question:
Given checkboxes named op[] with values 10, 15, and 5, the user selects the
first and last options. The PHP script loops over $_POST['op'] and echoes each
selected value followed by a space. What is the output?

Answer:
10 5
*/
function checkboxOutputExample(array $selectedValues = ['10', '5']): string
{
    // Join the selected checkbox values in the same order sent by the form.
    return implode(' ', $selectedValues);
}

/*
Question:
The user selects the label "Second Option", but that radio input has value
"first". The script prints the array stored under the submitted value. What is
the output?

Answer:
90 85 80
*/
function secondOptionMarksOutput(): string
{
    $marks = [
        'first' => [90, 85, 80],
        'second' => [94, 90, 85],
    ];

    // The selected label is "Second Option", but its HTML value is "first".
    $postedOption = 'first';

    return implode(' ', $marks[$postedOption]);
}

/*
Question:
After the second request, a cookie named month contains "Mar". The script echoes
$m[$_COOKIE['month']] and then sets the month cookie with an expired time. What
is the output and what happens to the cookie?

Answer:
Output is 10, and the cookie is deleted.
*/
function monthCookieSecondRequestExample(): array
{
    $months = ['Jan' => 5, 'Feb' => 7, 'Mar' => 10, 0 => 'Feb'];
    $months[] = 'Mar';

    // On the second request the browser sends the previous cookie value.
    $cookieValue = 'Mar';

    return [
        'output' => (string) $months[$cookieValue],
        'cookie' => 'deleted',
    ];
}
