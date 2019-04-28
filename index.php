<?php 

    $connection = mysqli_connect("localhost", "root", "", "calendar_app_build");
    if(!$connection){
        die("There was an error connecting to the database.");
    }

    
    function db_updateTheme($newTheme){
        global $connection;
        $query = "UPDATE theme SET cur_theme = '$newTheme' WHERE id = 1";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("Query failed: " . mysqli_error($connection));
        }
    }
    
    function db_insertNote($uid, $color, $text){
        global $connection;
        $text = mysqli_real_escape_string($connection, $text);
        $query = "INSERT INTO notes(note_id, note_color, note_text) VALUES('$uid', '$color', '$text')";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("Something went wrong on line 24");
        }
    }
    
    function db_updateNote($uid, $text){
        global $connection;
        $text = mysqli_real_escape_string($connection, $text);
        $query = "UPDATE notes SET note_text = '$text' WHERE note_id = '$uid' LIMIT 1";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("Something went wrong on line 44");
        }
    }
    
    function db_deleteNote($uid){
        global $connection;
        $query = "DELETE FROM notes WHERE note_id = '$uid'";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("Something went wrong on line 43");
        }
    }
    
    function setTheme(){
        global $connection;
        $query = "SELECT * FROM theme";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("Something went wrong.. derp");
        }
        
        while($row = mysqli_fetch_assoc($result)){
            return $row['cur_theme'];
        }
    }

    function getNoteData(){
        global $connection;
        $query = "SELECT * FROM notes";
        $result = mysqli_query($connection, $query);
        if(!$result){
            die("Something went wrong on line 66");
        }
        
        $id = 0;
        $color = 1;
        $text = "";
        
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['note_id'];
            $color = $row['note_color'];
            $text = $row['note_text'];
            
            ?>
                <script type="text/javascript">
                    
                    post_it = {
                        id: <?php echo json_encode($id); ?>,
                        note_num: <?php echo json_encode($color); ?>,
                        note: <?php echo json_encode($text); ?>
                    }
                    
                    post_its.push(post_it);
                    
                </script>
            
            <?php
        }
    }


    if(isset($_POST['color'])){
        db_updateTheme($_POST['color']);
    }

    if(isset($_POST['new_note_uid'])){
        db_insertNote($_POST['new_note_uid'], $_POST['new_note_color'], $_POST['new_note_text']);
    }
    
    if(isset($_POST['update_note_uid'])){
        db_updateNote($_POST['update_note_uid'], $_POST['update_note_text']);
    }
    
    if(isset($_POST['delete_note_uid'])){
        db_deleteNote($_POST['delete_note_uid']);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>Calendar App: Build</title>
    <link rel="icon" type="image/png" href="images/icon2.png" sizes="72x72">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/current_day.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" href="css/calendar_borders.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/portrait.css">
</head>
<body>
    
    <h3 class="background-text off-color">2019</h3>
    <h4 class="background-text off-color">Calendar</h4>
    
    <div id="current-day-info" class="color">
        
        <h1 id="app-name-landscape" class="center off-color default-cursor">My Calendar</h1>
        <div>
            <h2 class="center current-day-heading default-cursor" id="cur-year">2019</h2>    
        </div>
        <div>
            <h1 class="center current-day-heading default-cursor" id="cur-day">Monday</h1>
            <h1 class="center current-day-heading default-cursor" id="cur-month">June</h1>
            <h1 class="center current-day-heading default-cursor" id="cur-date">7</h1>
        </div>
    
        <button id="theme-landscape" class="font button" onclick="openModal(1)">Change Theme</button>
    </div>
    
    <div id="calendar">
      
      <h1 id="app-name-portrait" class="center off-color">My Calendar</h1>
      
      <table class="default-cursor">
          <thead class="color">
              <tr >
                  <th colspan="7" class="border-color">
                      <h4 id="cal-year">2018</h4>
                      <div>
                          <i onclick="previousMonth();" class="icon fas fa-caret-left"></i>
                          <h3 id="cal-month">July</h3>
                          <i onclick="nextMonth();" class="icon fas fa-caret-right"></i>
                      </div>
                  </th>
              </tr>
              <tr>
                  <th class="weekday border-color">Sun</th>
                  <th class="weekday border-color">Mon</th>
                  <th class="weekday border-color">Tue</th>
                  <th class="weekday border-color">Wed</th>
                  <th class="weekday border-color">Thu</th>
                  <th class="weekday border-color">Fri</th>
                  <th class="weekday border-color">Sat</th>
              </tr>
          </thead>

          <tbody id="table-body" class="border-color">
              <tr>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
              </tr>
              <tr>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
              </tr>
              <tr>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
              </tr>
              <tr>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
              </tr>
              <tr>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
              </tr>
              <tr>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
                  <td onclick="dayClicked(this);">1</td>
              </tr>
          </tbody>
          
      </table>
      <button id="theme-portrait" class="font button color" onclick="openModal(1)">Change Theme</button>
    </div>
    
    <dialog id="modal" closed>
            <div id="fav-color" hidden>
                <div class="popup">
                    <h4 class="center">What's your favorite color?</h4>
                    
                    <div id="color-options">
                        <div class="color-option">
                            <div class="color-preview" id="blue" style="background-color: #1B19CD;" onclick="updateColorData('blue')"></div>
                            <h5>Blue</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="red" style="background-color: #D01212;" onclick="updateColorData('red')"></div>
                            <h5>Red</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="purple" style="background-color: #721D89;" onclick="updateColorData('purple')"></div>
                            <h5>Purple</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="green" style="background-color: #158348;" onclick="updateColorData('green')"></div>
                            <h5>Green</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="orange" style="background-color: #EE742D;" onclick="updateColorData('orange')"></div>
                            <h5>Orange</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="deep-orange" style="background-color: #F13C26;" onclick="updateColorData('deep-orange')"></div>
                            <h5>Deep Orange</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="baby-blue" style="background-color: #31B2FC;" onclick="updateColorData('baby-blue')"></div>
                            <h5>Baby Blue</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="cerise" style="background-color: #EA3D69;" onclick="updateColorData('cerise')"></div>
                            <h5>Cerise</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="lime" style="background-color: #36C945;" onclick="updateColorData('lime')"></div>
                            <h5>Lime</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="teal" style="background-color: #2FCCB9;" onclick="updateColorData('teal')"></div>
                            <h5>Teal</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="pink" style="background-color: #F50D7A;" onclick="updateColorData('pink')"></div>
                            <h5>Pink</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="black" style="background-color: #212524;" onclick="updateColorData('black')"></div>
                            <h5>Black</h5>
                        </div>
                    </div>
                    
                    <button id="update-theme-button" class="button font" onclick="updateColorClicked()">Update</button>
                </div>
            </div>        
            
            <div id="make-note" hidden>
                <div class="popup">
                    <h4>Add a note to the calendar</h4>
                    <textarea id="edit-post-it" class="font" name="post-it" autofocus></textarea>
                    <div>
                        <button class="button font post-it-button" id="add-post-it" onclick="submitPostIt();">Post It</button>
                        <button class="button font post-it-button" id="delete-button" onclick="deleteNote();">Delete It</button>
                    </div>
                </div>
            </div>
    </dialog>
    
    
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
    <script type="text/javascript" src="js/data.js"></script>
    <script type="text/javascript" src="js/date.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/updating_color.js"></script>
    <script type="text/javascript" src="js/making_notes.js"></script>
    <script type="text/javascript" src="js/building_calendar.js"></script>
    <script type="text/javascript">
    
        updateColorData( <?php echo(json_encode(setTheme())); ?> );
        changeColor();
        document.body.style.display = "flex";
        
    </script>
    <?php getNoteData(); ?>
    <script type="text/javascript" src="js/start.js"></script>
</body>
</html>