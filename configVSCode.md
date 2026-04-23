# ⚙️ Extenções

## 🤖 GitHub 

* Git History
* GitLens
* GitHub Copilot Chat

## 🚀 PHP 

* PHP Intelephense
* PHP DocBlocker
* Inline Parameters for VSCode
* PHP Namespace Resolver
* PHP CS Fixer

Em setting.json:
```bash
    /**
    * PHP
    **/

    "php.suggest.basic": false,


    /**
    * PHP CS Fixer
    **/

    "[php]": {
        "editor.defaultFormatter": "junstyle.php-cs-fixer"
    },
    "php-cs-fixer.onsave": true,
    "php-cs-fixer.showOutput": false,
    "php-cs-fixer.autoFixByBracket": false,
    "php-cs-fixer.rules": "@PSR2",
    "php-cs-fixer.config": ".php-cs-fixer.php;.php_cs;.php_cs.dist",
    "php-cs-fixer.executablePath": "${extensionPath}/php-cs-fixer.phar",
```

## 🧪 Testes

* Test Explorer UI
* PHPUnit & Pest Test Explorer
* Better PHPUnit
* Better Pest

## 🚀 Laravel 

* Laravel Extra Intellisense
* laravel-blade by Christian Howe
* Laravel goto view
* Laravel Artisan
* Laravel Blade formatter

Em setting.json:
```bash
    "[blade]": {
        "editor.defaultFormatter": "shufo.vscode-blade-formatter",
        "editor.formatOnSave": true
    }
```

## 🧑‍💻 Outros

* DotENV
* Tailwind CSS IntelliSense
* advanced-new-file 
* File Utils
* Project Manager
* Thunder Client
* Code Spell Checker
* File Path Bar
* WakaTime
* Auto Close Tag
* Auto Rename Tag
* Auto Complete Tag

# 👁️ Visual

* Fluent Icons
* Material Icon Theme
* Bearded Theme || Moonlight Theme

# setting.json

```bash
    {
        /**
        * Visual
        **/

        "editor.fontSize": 20,
        "files.autoSave": "afterDelay",
        "breadcrumbs.enabled": false,
        "editor.stickyScroll.enabled": false,
        "window.nativeTabs": true,
        "editor.minimap.enabled": false,

        /**
        * GitHub
        **/

        "github.copilot.enable": {
            "*": true,
            "plaintext": false,
            "markdown": true,
            "scminput": false
        },
        "gitlens.currentLine.enabled": false,

        /**
        * PHP
        **/

        "php.suggest.basic": false,


        /**
        * PHP CS Fixer
        **/

        "[php]": {
            "editor.defaultFormatter": "junstyle.php-cs-fixer"
        },
        "php-cs-fixer.onsave": true,
        "php-cs-fixer.showOutput": false,
        "php-cs-fixer.autoFixByBracket": false,
        "php-cs-fixer.rules": "@PSR2",
        "php-cs-fixer.config": ".php-cs-fixer.php;.php_cs;.php_cs.dist",
        "php-cs-fixer.executablePath": "${extensionPath}/php-cs-fixer.phar",

        /**
        * Blade
        **/

        "bladeFormatter.format.sortTailwindcssClasses": true,
        "[blade]": {
            "editor.defaultFormatter": "shufo.vscode-blade-formatter",
            "editor.formatOnSave": true
        },

        "filePathBar.pathStyle": "relative",
        "workbench.iconTheme": "material-icon-theme",
        "workbench.productIconTheme": "fluent-icons",
        "php-cs-fixer.lastDownload": 1776356474310,
        "workbench.colorTheme": "Bearded Theme Aquarelle Hydrangea",
        "workbench.sideBar.location": "right",
        "window.titleBarStyle": "native",
        "window.customTitleBarVisibility": "never",
        "editor.fontFamily": "Dank Mono",
        "editor.fontLigatures": true,
    }
```