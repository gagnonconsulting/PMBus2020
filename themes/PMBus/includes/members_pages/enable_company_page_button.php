<?php
add_action( 'post_submitbox_misc_actions', 'custom_button' );

function custom_button(){ ?>
    <style>
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    </style>
    <div id="major-publishing-actions" style="overflow:hidden">
    <div id="publishing-action">
    <h2 style="float:left"><strong>SMIF Company Page?<strong></h2>
    <label style="display:block; float:right;" class="switch">
    <input type="checkbox" id="myCheck"  onclick="displayCompany()">
    <span class="slider round"></span>
    </label>

    </div>
    </div>

    <script>
    function displayCompany() {
      var checkBox = document.getElementById("myCheck");
      var product = document.getElementById("my-meta-box-id");
      if (checkBox.checked == true){
          product.style.display = "block";
      } else {
         product.style.display = "none";
      }
      var company = document.getElementById("radio-companiesdiv");
      if (checkBox.checked == true){
          company.style.display = "block";
      } else {
         company.style.display = "none";
      }
     var image = document.getElementById("postimagediv");
     if (checkBox.checked == true){
         image.style.display = "block";
     } else {
        image.style.display = "none";
     }
    }
    </script>

  	<?php
}
