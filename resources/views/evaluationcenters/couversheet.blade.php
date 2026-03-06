<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>cover sheet</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background: #fff;
      color: #000;
    }

    h2 {
      background-color: #e91e63;
      color: white;
      padding: 10px;
      text-align: center;
      border-radius: 5px;
    }

    .form-wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .section {
      border: 2px solid #e91e63;
      border-radius: 5px;
      padding: 20px;
      background: #fefefe;
      flex: 1;
      min-width: 280px;
    }

    .title {
      font-size: 10px;
      font-weight: bold;
      color: #e91e63;
      margin-bottom: 5px;
      text-align: center;
    }

    .bubble-table {
      width: 100%;
      border-collapse: collapse;
    }

    .bubble-table th,
    .bubble-table td {
      border: 1px solid #ccc;
      text-align: center;
      padding: 1px;
    }

    .circle {
      width: 12px;
      height: 12px;
      border: 2px solid #e91e63;
      border-radius: 50%;
      margin: auto;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      transition: background-color 0.2s ease;
    }

    .circle.filled {
      background-color: #e91e63;
      color: white;
    }

    .digit-column {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 5px;
    }

    .digit-label {
      font-weight: bold;
      margin-bottom: 10px;
    }

    .signature-row {
      display: flex;
      gap: 15px;
      margin-bottom: 10px;
    }

    .signature-row div {
      flex: 1;
    }

    input[type="text"],
    input[type="date"] {
      width: 100%;
      padding-bottom: 30px;
          border: 1px solid #574848;

      border-radius: 4px;
    }
  @media print {
  body {
    margin: 0;
    padding: 0;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }

  .sheet {
    page-break-after: always;
    height: 100vh;
    box-sizing: border-box;
    padding: 10px;
  }

  .page {
    height: 48vh; /* Two pages per A4 sheet */
    margin-bottom: 10px;
    border: 1px solid #e91e63;
    padding: 10px;
    box-sizing: border-box;
    page-break-inside: avoid;
  }

  h2 {
    font-size: 18px;
    margin: 4px 0;
    padding: 6px;
  }

  .form-wrapper {
    gap: 10px;
    flex-wrap: wrap;
  }

  .section {
    padding: 10px;
    font-size: 12px;
  }

  .bubble-table th,
  .bubble-table td {
    font-size: 10px;
    padding: 4px;
  }

  .circle {
    width: 14px;
    height: 14px;
    font-size: 8px;
  }

  input[type="text"],
  input[type="date"] {
    font-size: 10px;
    padding: 6px;
  }

  .page-break {
    display: none !important;
  }
}


  </style>
  <script>
    function toggleBubble(el) {
      el.classList.toggle("filled");
    }
  </script>
</head>
<body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    }); 
</script>
@foreach ($applications as $dummy)
    
 
  <h2>Coversheet For   Bundle Number:
                        <?php
                      $ap = $dummy->candidate->approvedprogramme;
                        $dummy_code = '';
                        if(!is_null($ap->institute)){
                        $dummy_code = $ap->institute->dummy_code;
                        }
                       
                        $institute_code= $dummy_code;
                        ?>
                                                    {{ $ap->id }}-{{ $dummy_code }}-{{ $ap->programme->id }}-{{ $subject->id }}

                            {{-- {{$approvedprogramme->id}}-{{$dummy_code}}-{{$approvedprogramme->programme->id}}-{{$subject->id}} --}}
                         Dummy Code: {{$dummy->dummy_no}}</h2>

                         

  <div class="form-wrapper">
    <!-- Marks Entry Section -->
    <div class="section">
      <div class="title">Marks Entry</div>
      <table class="bubble-table">
        <thead>
          <tr>
            <th>Q. No</th>
            <th>a</th>
            <th>b</th>
            <th>c</th>
            <th>d</th>
            <th>e</th>
            <th>f</th>
            <th>g</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>2</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>3</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>4</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>5</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>6</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>7</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>8</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>9</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>10</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>11</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>12</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Total Marks</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          {{-- <tr>
            <td>14</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>15</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr> --}}
          <!-- Add more rows as needed -->
        </tbody>
      </table>
    </div>

    <!-- Total Marks Section -->
    <div class="section">
      <div class="title">Total Marks</div>
      <div style="display: flex; justify-content: center; gap: 40px;">
        <!-- Tens Digit -->
        <div class="digit-column">
                       <table class="bubble-table">
        <thead>
          <tr>
            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
          </tr>
          <tr>
            <td><div class="circle" onclick="toggleBubble(this)">0</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">0</div></td>
          </tr>
          <tr>
            <td><div class="circle" onclick="toggleBubble(this)">1</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">1</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">2</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">2</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">3</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">3</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">4</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">4</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">5</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">5</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">6</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">6</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">7</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">7</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">8</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">8</div></td>
          </tr>
           <tr>
            <td><div class="circle" onclick="toggleBubble(this)">9</div></td>
            <td><div class="circle" onclick="toggleBubble(this)">9</div></td>
          </tr>
        </thead>
        
        <tbody>
          </tbody>
          </table>

          
        </div>

      </div>
    </div>

    <!-- Evaluator & Moderator Section -->
    <div class="section">
      <div class="title">Evaluator Details</div>
      
        
        
      <div style="padding: 10px;">
          <label for="evaluator">Signature of Evaluator ______________________________________</label>
       
          <label for="evaluator">Evaluation Date ________________________</label>
        </div>
       
    
        
      <div style="padding: 10px;">
          <label for="moderator">Signature of Moderator ______________________________________</label>
          
          <label for="moderator">Moduration Date _______________________</label>
          
        </div>

      <div style="padding: 10px;">
          <label for="moderator">Marks Enter By ____________________________________________</label>
          
        
          <label for="moderator">Marks Enter Date ______________________</label>
         
        </div>
    </div>
  </div>
  <div class="page-break"></div>

@endforeach
</body>
</html>
