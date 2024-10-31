<?php

/**
 * @package Password Generators
 * @version 1.1
 */
/*
Plugin Name: Password generators
Plugin URI: http://wordpress.org/plugins/password-generators/
Description: A simple plugin to generate secure password. Please visit http://passwordgenerator.keresetlen.com/
Author: S.M Jabid hasan
Version: 1.1
Author URI: http://smjabidhasan.info

License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
add_action( 'admin_menu', 'passgen_menu');
 
 
function passgen_menu() {
 
add_menu_page( 'Password Generator page', 'Password Generator','manage_options', __FILE__, 'passgen_main',20 );
 }
  

  function passgen_main(){

 ?>

  <html>
<head>
  <title>Password generator</title>
  <style type="text/css">
    * { font-family: Helvetica,Arial,Verdana,sans-serif; }
    p { color: #444; }
    input, button { font-size: 16px; }
    label, button { cursor: pointer; }
    pre { font-size: 17px; font-family: monospace; }
    small { color: #999; text-align: right; }
    li { line-height: 180%; }
    li input { font-family: monospace; }
  </style>
  <script>

      var passamount, passlength, passmemo;
    passamount = 5;
    passlength = 8;
    passmemo = false;

    // Set defaults
    var consonant, letter, password, vowel;
    letter = /[a-zA-Z]$/;
    vowel = /[aeiouAEIOU]$/;
    consonant = /[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]$/;

    var password = function(length, memorable, pattern, prefix) {
      var char, n;
      if (length == null) {
        length = 10;
      }
      if (memorable == null) {
        memorable = true;
      }
      if (pattern == null) {
        pattern = /\w/;
      }
      if (prefix == null) {
        prefix = '';
      }
      if (prefix.length >= length) {
        return prefix;
      }
      if (memorable) {
        if (prefix.match(consonant)) {
          pattern = vowel;
        } else {
          pattern = consonant;
        }
      }
      n = (Math.floor(Math.random() * 100) % 94) + 33;
      char = String.fromCharCode(n);
      if (memorable) {
        char = char.toLowerCase();
      }
      if (!char.match(pattern)) {
        return password(length, memorable, pattern, prefix);
      }
      return password(length, memorable, pattern, "" + prefix + char);
    },
    createFields = function(a,l){
      var output = "";
      var target = document.getElementById('passwords');
      var easy = document.getElementById('memorable').checked;
      for(var i = 0; i < a; i++) {
        output += '<li><input value="' + password(l,easy,null,null) + '" size="'+l+'" /></li>';
      }
      target.innerHTML=output;
      updateFields(a,l);
    },
    updateFields = function(a,l){
      document.getElementById('amount').value = a;
      document.getElementById('length').value = l;
    };

    document.addEventListener('DOMContentLoaded', function() {
      createFields(passamount,passlength);
      if (passmemo)
        document.getElementById('memorable').checked = true;
      else
        document.getElementById('memorable').checked = false;
    });

  </script>
</head>
<body>

  <h1>Password generator</h1>
  <p id="predefined">
    <a href="" onclick="createFields(5,8); return false">Default</a> |
    <a href="" onclick="createFields(5,24); return false" title="24 chars">MySQL</a> |
    <a href="" onclick="createFields(5,12); return false">12</a> |
    <a href="" onclick="createFields(5,16); return false">16</a>
  </p>
  <form method="get">
    <fieldset>
      <legend>Generate passwords</legend>
      <p>
        Give me <input type="text" name="amount" id="amount" size="2" value="5" />
        passwords with
        <input type="text" name="length" id="length" size="2" value="8" />
        characters.
        <button type="submit" onclick="createFields(document.getElementById('amount').value,document.getElementById('length').value); return false">Generate</button>
        <label><input type="checkbox" id="memorable"> Easy?</label>
      </p>
    </fieldset>
   </form>
   <ol id="passwords"></ol>
   <hr>
   <small>See The Demo<a href="http://passwordgenerator.keresetlen.com/" target="_blank">PasswordGenerator</a></small>
</body>
</html>

<?php
//Hooks a function to a specific action.
add_action( 'admin', 'passgen_main' );
}