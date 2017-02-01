# MaVoixSupportGenerator


Web form and tools to generate avatar, wallpapers and support overlays for social networks and others communication resources.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

PHP 5.6 or later (with GD)

### Installing

1. Copy file on your server
1. Make copy of sample.config.php and rename it config.php
1. Check your settings in config.php (URL, file limit, etc)
1. Chmod 777 on /tmp folder
1. That's all !

_Checking-configuration system come later_

## Running the tests

Open your web site http://url-of-the-app.net and try to select "Profil Facebook photo", then add your photo and get a new picture with MAVOIX colors.

### Break down into end to end tests

_todo : writing this section_

### And coding style tests

_todo : writing this section_

## Deployment

###How to create a new output picture

1. Create folder in **src/folder** ( for ex : my-new-picture )
1. Add all file you need to generate picture in this folder (font (TrueType),pictures png or jpg)
1. Create data.json (see section **How to write your data.json file** below)
1. That's all !

###How to write your data.json file

For now, all field are mandatory.

TIPS : if nothing appear in the select menu at the first page, there is something wrong with your data.json.

_TODO : create default value when a field required is empty_ 
1. structure of file :

 ```
 {
    "title": "The name of my picture",
    "thumb": "thumb.png", 
    "width": 500,
    "height": 500,
    "format": "png",
    "layers" : { ... }
  }
  ```


**title** : The name of your picture (will appear in select format at the first step)

**thumb** : It's a preview of what the script will do

**width** : width in PX of your output picture

**height** : height in PX of your output picture

**format** : format of your output picture (png only for now)

**layers** : Lists of layers **see section below**

###Layers in data.json

All layers are process in order of the number at the first key .

```
...
"layers" {
    "1" : { layer info ...},
    "2" : { layer info ...},
    "3" : { layer info ...}
} 
```

#### Image :
 ```
"1": {
  "type": "image",
  "src": "myImage.png",
  "x": 0,
  "y": 0,
  "opacity": "1"
}
 ```
 
 #### input => text
  ```
 "1": {
      "type": "text",
      "text": "My text",     
      "anchor":"center",
      "x": 0,
      "y": 0,
      "fontfile": "MyFont.ttf",
      "fontsize": 14,
      "color": "#000000"
    },
  ```

#### input => text
 ```
"1": {
     "type": "input",
     "type_input": "text",
     "label": "Label of field",
     "placeholder": "Placholder HTML of field",
     "default_value": "My Text by default",
     "anchor":"center",
     "x": 0,
     "y": 0,
     "fontfile": "MyFont.ttf",
     "fontsize": 14,
     "color": "#000000"
   },
 ```
 
 
 #### input => image (for upload)
 **IMPORTANT : ONLY ONE LAYER WITH INPUT UPLOAD BY data.json** 
 
 _TODO: multiple upload_
 
  ```
 "1": {
       "type": "input",
       "type_input": "upload",
       "label": "Label of field",
       "x": 0,
       "y": 0,
       "height": 500,
       "width": 500,
       "opacity": "1"
     },
  ```
 #### Example 

Check in src folder
```
{
  "title": "Bannière événement Facebook avec une image",
  "thumb": "thumb.png",
  "width": 784,
  "height": 295,
  "format": "png",
  "layers": {
    "1": {
      "type": "image",
      "src": "background-empty.png",
      "x": 0,
      "y": 0,
      "opacity": "1"
    },
    "2": {
      "type": "input",
      "type_input": "upload",
      "label": "Illustration",
      "x": 327,
      "y": 13,
      "height": 130,
      "width": 130,
      "opacity": "1"
    },
    "3": {
      "type": "input",
      "type_input": "text",
      "label": "Titre",
      "default_value": "ATELIERS CO—CONSTRUCTION . PARIS",
      "x": 0,
      "y": 14,
      "fontfile": "MyriadPro-Bold.otf",
      "fontsize": 14,
      "color": "#000000"
    },
    "4": {
      "type": "input",
      "type_input": "text",
      "label": "Baseline",
      "default_value": "Hack de l'assemblée nationale J-201",
      "x": 20,
      "y": 36,
      "fontfile": "MyriadPro-Semibold.otf",
      "fontsize": 10,
      "color": "#000000"
    },
    "5": {
      "type": "input",
      "type_input": "text",
      "label": "Date",
      "default_value": "mardi 22 novembre / 19h - 22 h",
      "x": 20,
      "y": 65,
      "fontfile": "MyriadPro-Bold.otf",
      "fontsize": 12,
      "color": "#000000"
    },
    "6": {
      "type": "input",
      "type_input": "text",
      "label": "Lieu",
      "default_value": "'social bar' 25 rue Villiot paris 12 // Métro bercy . gare de Lyon // Bus 63 / 65 / 20",
      "x": 20,
      "y": 78,
      "fontfile": "MyriadPro-Semibold.otf",
      "fontsize": 7,
      "color": "#000000"
    },
    "7": {
      "type": "image",
      "src": "assemblee.png",
      "x": 443,
      "y": 49,
      "opacity": "1"
    }
  }
}
```

## Built With

* [SimpleClass](https://www.abeautifulsite.net/the-simple-image-class-for-php) TODO : Update the latest version 
* [Bootstap](http://getbootstrap.com/) 
* [Jquery](https://jquery.com/) 
* [Croopie](https://foliotek.github.io/Croppie/) 

## Contributing

_todo : writing this section_

## Versioning

_todo : writing this section_ 

## Authors

* **Team #MAVOIX** - *Initial work* - [MAVOIX](https://github.com/MaVoix)

## License

_todo : writing this section_ 

## Acknowledgments

_todo : writing this section_ 
