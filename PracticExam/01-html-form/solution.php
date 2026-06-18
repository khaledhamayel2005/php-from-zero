<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Workshop Registration</title>
  </head>
  <body>
    <header>
      <h1>Workshop Registration</h1>
      <p>Register for a short PHP practical workshop.</p>
    </header>

    <main>
      <form action="solution.php" method="post">
        <p>
          <label>Full name:
            <input type="text" name="fullname">
          </label>
        </p>

        <p>
          <label>Email:
            <input type="email" name="email">
          </label>
        </p>

        <p>
          <label>Major:
            <select name="major">
              <option value="cs">Computer Science</option>
              <option value="cis">Computer Information Systems</option>
              <option value="it">Information Technology</option>
            </select>
          </label>
        </p>

        <fieldset>
          <legend>Level</legend>
          <label><input type="radio" name="level" value="beginner"> Beginner</label>
          <label><input type="radio" name="level" value="intermediate"> Intermediate</label>
          <label><input type="radio" name="level" value="advanced"> Advanced</label>
        </fieldset>

        <fieldset>
          <legend>Skills</legend>
          <label><input type="checkbox" name="skills[]" value="html"> HTML</label>
          <label><input type="checkbox" name="skills[]" value="php"> PHP</label>
          <label><input type="checkbox" name="skills[]" value="mysql"> MySQL</label>
        </fieldset>

        <p>
          <label>Notes:<br>
            <textarea name="notes" rows="4" cols="40"></textarea>
          </label>
        </p>

        <p>
          <button type="submit">Register</button>
          <button type="reset">Clear</button>
        </p>
      </form>

      <h2>Schedule</h2>
      <table border="1" cellpadding="6">
        <tr>
          <th>Day</th>
          <th>Topic</th>
          <th>Time</th>
        </tr>
        <tr>
          <td>Saturday</td>
          <td>Forms</td>
          <td>10:00</td>
        </tr>
        <tr>
          <td>Sunday</td>
          <td>Sessions and Database</td>
          <td>12:00</td>
        </tr>
      </table>
    </main>
  </body>
</html>

