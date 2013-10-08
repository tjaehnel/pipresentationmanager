pipresentationmanager
=====================

PHP GUI to prepare a PiPresents compatible slideshow

General configuration
---------------------
The configuration file is located in the root of the installation and
called config.php
See the commented example for details. A call to dirname(__FILE__)
returns the absolute path of the directory the config.php is located
in without trailing slash.

Text Configuration
------------------
Backgrounds can be supplied with an optional configuration file
defining a text field to put an overlay text on the image.
If this file is available and has a "text" section, the Web-GUI will
display a text area field to modify the text displayed.

The configuration file has to be located next to the image file,
sharing the same filename but with extension .json instead of .jpg

The configuration file is in JSON format and looks like this.
(see example in testenvironment/data)

    {
      "text": {
        "font": "Helvetica",
        "size": "30",
        "color": "white",
        "bold": true,
        "italic": true,
        "underline": false,
        "overstrike": true,
        "posX": "50",
        "posY": "50"
      }
    }

__font:__
Font Family of the Text. Depending on the installed fonts.
e.g. Arial, Helvetica, Times, Courier
To find out which font families are installed, run the _tkfonts.sh_
command from the _scripts_ subdirectory. Please note that X has
to be running and you have to run the command as user _pi_. 

__size:__
Font size in pixels

__color:__
Name of color or RGB code:
e.g.: red, green, white, #33FF33

__bold, italic, underline, overstrike:__
true or false (don't set in quotes!)


