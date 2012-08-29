<?php

class ThingsController {
  
  public static function index() {
    render_view('things/index.php', array(
      'what'=>'World'));
  }

}

