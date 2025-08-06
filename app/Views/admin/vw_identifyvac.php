<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Decision to Fill Vacancy</title>
  <style>
    @page {
      size: A4 landscape;
      margin: 20mm;
    }

    html, body {
      width: 100%;
      min-height: 794px;
      margin: 0;
      padding: 20px;
      font-family: Arial, sans-serif;
      font-size: 12pt;
      box-sizing: border-box;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 10px;
    }

    .title-group {
      text-align: right;
    }

    .title-group h2 {
      margin: 0;
      color: #6c63ff;
      font-size: 16pt;
    }

    .title-group p {
      margin: 0;
      font-size: 10pt;
      color: #666;
    }

    .info {
      margin: 20px 0 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    th, td {
      border: 1px solid #000;
      padding: 8px;
      vertical-align: top;
    }

    th {
      text-align: center;
      background-color: #f0f0f0;
      font-weight: bold;
    }

    td textarea {
      width: 100%;
      border: none;
      resize: none;
      overflow: hidden;
      font-family: inherit;
      font-size: inherit;
      line-height: 1.4;
      box-sizing: border-box;
      padding: 4px;
      min-height: 60px;
    }

    td textarea:focus {
      outline: none;
    }

    .date {
      margin-top: 30px;
    }

    .signature-section {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }

    .signature-box {
      width: 45%;
      line-height: 1.8;
    }

    .form-actions {
      margin-top: 40px;
      text-align: center;
    }

    .form-actions button {
      padding: 10px 20px;
      margin: 0 10px;
      font-size: 14px;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      background-color: #6c63ff;
      color: white;
      transition: background-color 0.3s ease;
    }

    .form-actions button:hover {
      background-color: #574fd6;
    }

    .form-actions button[type="reset"] {
      background-color: #ccc;
      color: #000;
    }

    .form-actions button[type="reset"]:hover {
      background-color: #999;
    }

  </style>
</head>
<body>

  <div class="header">
    <div></div>
    <div class="title-group">
      <h2>RECRUITMENT POLICY</h2>
      <p>DECISION TO FILL VACANCY</p>
      <p><small>ANP – HR</small></p>
    </div>
  </div>
  <hr>

  <div class="info">
    Directors should start planning immediately if a vacancy occurs or as soon as it is known that a vacancy will be occurring by considering the following. The directors or supervisors need to fill in this form and submit it to HR. This form needs to be submitted to HR for the Recruitment Plan before the advertisement of the vacancy. This form is based on ANPM/05/03/02 Rev 1 Recruitment Policy clause “3.2 Decision to Fill a Vacancy.”
  </div>

  <p><strong>Name of the Position:</strong> ____________________________</p>

  <table>
    <thead>
      <tr>
        <th style="width: 50%">Questions</th>
        <th style="width: 50%">Answers</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Does the job need to be <a href="#">filled</a>?</td>
        <td><textarea name="answer1" id="answer1" oninput="autoResize(this)"></textarea></td>
      </tr>
      <tr>
        <td>What are the implications of not filling the vacancy?</td>
        <td><textarea name="answer2" id="answer2" oninput="autoResize(this)"></textarea></td>
      </tr>
      <tr>
        <td>What is the best method for filling the vacancy?</td>
        <td><textarea name="answer3" id="answer3"oninput="autoResize(this)"></textarea></td>
      </tr>
      <tr>
        <td>Do any aspects of the duties need to be changed to reflect current job requirements?</td>
        <td><textarea name="answer4" id="answer4"oninput="autoResize(this)"></textarea></td>
      </tr>
      <tr>
        <td>What are the skills and qualities required to perform the duties?</td>
        <td><textarea name="answer5" id="answer5" oninput="autoResize(this)"></textarea></td>
      </tr>
      <tr>
        <td>Do the current hours fit the duties?</td>
        <td><textarea name="answer6" id="answer6" oninput="autoResize(this)"></textarea></td>
      </tr>
      <tr>
        <td>Does the budget allow for the vacancy to be filled?</td>
        <td><textarea name="answer7" id="answer7" oninput="autoResize(this)"></textarea></td>
      </tr>
      <tr>
        <td>When is a candidate expected to join the ANP?</td>
        <td><textarea name="answer8" id="answer8" oninput="autoResize(this)"></textarea></td>
      </tr>
    </tbody>
  </table>

  <div class="date">
    <strong>Date:</strong> ________________________
  </div>

  <div class="signature-section">
    <div class="signature-box">
      <strong>Approved by (relevant directorate/department)</strong><br><br>
      Name: _______________________<br>
      Position: _____________________
    </div>
    <div class="signature-box">
      <strong>Received by</strong><br><br>
      Name: _______________________<br>
      Position: _____________________
    </div>
  </div>

    <div class="form-actions">
      <button type="submit" onclick="submitForm()">Submit</button>
      <button type="reset">Cancel</button>
    </div>


  <script>
    function autoResize(textarea) {
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    }

    window.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('textarea').forEach(textarea => {
        autoResize(textarea);
        textarea.addEventListener('input', () => autoResize(textarea));
      });
    });


    function submitForm() { 
     var answer1 = $("#answer1").val();
     var answer2 = $("#answer2").val();
     var answer3 = $("#answer3").val();
     var answer4 = $("#answer4").val();
     var answer5 = $("#answer5").val();
     var answer6 = $("#answer6").val();
     var answer7 = $("#answer7").val();
     var answer8 = $("#answer8").val();
     var position = $("#position").val();
     var date = $("#date").val();


      $.ajax({
        url: '<?= base_url('admin/vacancy/submitvacancyform') ?>',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: {
          answer1: answer1,
          answer2: answer2,
          answer3: answer3,
          answer4: answer4,
          answer5: answer5,
          answer6: answer6,
          answer7: answer7,
          answer8: answer8,
          position: position,
          date: date
        },
        success: function(response) {
          alert('Form submitted successfully!');
        },
        error: function(error) {
          alert('Error submitting form. Please try again.');
        }
      });
    }
  </script>

</body>
</html>
