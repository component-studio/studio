import Phaser from 'phaser';
window.Phaser = Phaser;

class Example extends Phaser.Scene
{
    init ()
    {
        //  Inject our CSS
        const element = document.createElement('style');

        document.head.appendChild(element);

        const sheet = element.sheet;

        let styles = '@font-face { font-family: "mini_pixel"; src: url("/chronicles/fonts/mini_pixel-7.ttf") format("truetype"); }\n';

        sheet.insertRule(styles, 0);

        styles = '@font-face { font-family: "old_school_adventures"; src: url("/chronicles/fonts/old-school-adventures.ttf") format("truetype"); }';

        sheet.insertRule(styles, 0);

        styles = '@font-face { font-family: "byte_bounce"; src: url("/chronicles/fonts/byte_bounce.ttf") format("truetype"); }';

        sheet.insertRule(styles, 0);

        styles = '@font-face { font-family: "small_bold_pixel"; src: url("/chronicles/fonts/small_bold_pixel-7.ttf") format("truetype"); }';

        sheet.insertRule(styles, 0);

        styles = '@font-face { font-family: "small_pixel"; src: url("/chronicles/fonts/small_pixel-7.ttf") format("truetype"); }';

        sheet.insertRule(styles, 0);
    }

    preload ()
    {
        this.load.setBaseURL('http://chroniclesgame.test/');

        this.load.image('sky', '/chronicles/images/assets/background.png');
        this.load.image('logo', '/chronicles/images/assets/logo.png');

        this.load.audio('intro', ['/chronicles/audio/intro-short.mp3']);

        this.load.script('webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js');

    }

    create ()
    {

        const add = this.add;
        const tweens = this.tweens;
        const time = this.time;

        WebFont.load({
            custom: {
                families: [ 'mini_pixel', 'old_school_adventures', 'byte_bounce', 'small_bold_pixel', 'small_pixel' ]
            },
            active: function () {
                let fadingText = add.text(window.innerWidth/2 + 5, window.innerHeight/2 + 200, 'Press Enter', { fontFamily: 'byte_bounce', fontSize: 60, color: '#fffe91', stroke: '#401513', strokeThickness: 8 }).setShadow(2, 2, '#401513', 2, false, true);
                fadingText.setOrigin(0.5, 0.5);
                fadingText.setAlpha(0);
                
                
                tweens.add({
                    targets: fadingText,
                    alpha: { from: 0, to: 1 },
                    ease: 'Linear', // 'Cubic', 'Elastic', 'Bounce', 'Back'
                    duration: 1200,
                    repeat: -1, // -1 for infinite loop
                    yoyo: true // Yoyo effect to fade back out
                });
            }
        });

        let introMusic = this.sound.add("intro", { loop: true });
        let image = this.add.image(window.innerWidth/2, window.innerHeight/2, 'sky');
        let scaleX = this.cameras.main.width / image.width;
        let scaleY = this.cameras.main.height / image.height;
        let scale = Math.max(scaleX, scaleY);

        let logoShadow = this.add.sprite(window.innerWidth/2, window.innerHeight/2 - 90, 'logo');
        
        logoShadow.tint = 0x000000;
        logoShadow.alpha = 0.4;
        logoShadow.setScale(0.51);

        let logo = this.add.image(window.innerWidth/2, window.innerHeight/2 - 100, 'logo');
        logo.setScale(0.5);
        logo.setOrigin(0.5, 0.5);

        image.setScale(scale).setScrollFactor(0);
        introMusic.play();
        
    }
}

const config = {
    type: Phaser.AUTO,
    mode: Phaser.Scale.FIT,
    autoCenter: Phaser.Scale.CENTER_BOTH,
    width: window.innerWidth,
    height: window.innerHeight,
    scene: Example,
    parent: 'chronicle',
    physics: {
        default: 'arcade',
        arcade: {
            gravity: { y: 200 }
        }
    }
};

const game = new Phaser.Game(config);
window.game = game;

window.start = function(){
    document.getElementById('chronicle').classList.remove('hidden');
    document.getElementById('start').classList.add('hidden');
}

window.loadFont = function(name, url) {
    var newFont = new FontFace(name, `url(${url})`);
    newFont.load().then(function (loaded) {
        document.fonts.add(loaded);
    }).catch(function (error) {
        return error;
    });
}