var visible = [false,false,false,false,false,false,false,false,false,false];


var Container = PIXI.Container;
var AutoDetectRenderer = PIXI.autoDetectRenderer;
var Loader = PIXI.loader;
var Resources = PIXI.loader.resources;
var Sprite = PIXI.Sprite;
var TextureCache = PIXI.utils.TextureCache;
var Rectangle = PIXI.Rectangle;
var ParticleContainer = PIXI.particles.ParticleContainer;
var Graphics = PIXI.Graphics;
var Text = PIXI.Text;


var renderer = AutoDetectRenderer(1024, 768, { transparent: true });
document.body.appendChild(renderer.view);
var mainScene=new Container();
var stage=new Container();


var spriteCards=new Array(10);
//8 : bin
//9 : stack


//Variable nécessaire pour l'AJAX
var xhr;


var ntt=new Array(8);

Loader
    .add("js/assets/background.jpg")
    .add("js/assets/cardnumbers.json")
    .add("js/assets/cards.json")
    .on("progress",progress)
    .load(setup);

function progress(loader, resource) {
    console.log("loading: " + resource.url);
    console.log("progress: " + loader.progress + "%");
}

function setup() {
    var textureBackground=TextureCache["js/assets/background.jpg"];

    var textureGuard=TextureCache["guard.png"];
    var texturePriest=TextureCache["priest.png"];
    var textureBaron=TextureCache["baron.png"];
    var textureHandmaid=TextureCache["handmaid.png"];
    var texturePrince=TextureCache["prince.png"];
    var textureKing=TextureCache["king.png"];
    var textureCountess=TextureCache["countess.png"];
    var texturePrincess=TextureCache["princess.png"];

    var textureVerso=TextureCache["verso.png"];

    ntt[0]=textureGuard;
    ntt[1]=texturePriest;
    ntt[2]=textureBaron;
    ntt[3]=textureHandmaid;
    ntt[4]=texturePrince;
    ntt[5]=textureKing;
    ntt[6]=textureCountess;
    ntt[7]=texturePrincess;


    //Un for pour l'effet transparent au survol des cartes
    for (let i=0;i<spriteCards.length;i++) {
        spriteCards[i]=new Sprite(textureVerso);
        spriteCards[i].interactive = true;
        spriteCards[i].anchor.set(0.5,0.5);
        setVisible(i,false);

        spriteCards[i].on("mouseover", function(e){
            if (isVisible(i)) {
		            this.alpha=0.75;
            }
        })

        spriteCards[i].on("mouseout", function(e){
            if (isVisible(i)) {
		            this.alpha=1;
            }
        })

    }

    //TODO Mettre le truc au norme (la première carte est à gauche)

    spriteCards[0].x=921/2-127/2;
    spriteCards[0].y=679;

    spriteCards[1].x=921/2+127/2;
    spriteCards[1].y=679;

    spriteCards[2].rotation=Math.radians(-90);
    spriteCards[2].x=175/2+745;
    spriteCards[2].y=400;

    spriteCards[3].rotation=Math.radians(-90);
    spriteCards[3].x=175/2+745;
    spriteCards[3].y=400-127.5;

    spriteCards[4].rotation=Math.radians(180);
    spriteCards[4].x=921/2+127/2;
    spriteCards[4].y=175/2;

    spriteCards[5].rotation=Math.radians(180);
    spriteCards[5].x=921/2-127/2;
    spriteCards[5].y=175/2;

    spriteCards[6].rotation=Math.radians(90);
    spriteCards[6].x=175/2;
    spriteCards[6].y=400;

    spriteCards[7].rotation=Math.radians(90);
    spriteCards[7].x=175/2;
    spriteCards[7].y=400-127.5;

    spriteCards[8].x=921/2-75;
    spriteCards[8].y=325;

    spriteCards[9].x=921/2+75;
    spriteCards[9].y=325  ;
    //sprite.anchor.set(0.5,0.5);
    /*var textureGuard=TextureCache["verso.png"];
      var texture6=TextureCache["6.png"];


      sprite6=new Sprite(texture6);
      spriteGuard=new Sprite(textureGuard);/*/
    spriteBackground=new Sprite(textureBackground);
    mainScene.addChild(spriteBackground);

    for (let i=spriteCards.length-1;i>-1;i--) {
        mainScene.addChild(spriteCards[i]);
    }
    stage.addChild(mainScene);

    setVisible(0,true);
    setVisible(1,true);

    setVisible(2,true);
    setVisible(3,true);

    setVisible(4,true);
    setVisible(5,true);

    setVisible(6,true);
    setVisible(7,true);

    setVisible(8,true);
    setVisible(9,true);

    state=play;

    //TODO Mettre ça dans une fonction pour défausser
    var tween = new TWEEN.Tween(spriteCards[4])
  	.to({ x: spriteCards[8].x, y: spriteCards[8].y, rotation: spriteCards[8].rotation }, 1000)
  	.onUpdate(function() {
  		console.log(this.x, this.y);
  	})
	  .start();
    gameLoop();
}


//Player (1-4) Card (1-8 -> guard-princess 9->verso)
function addCardToPlayer(player,card) {
    console.log("addCardToPlayer : (player : "+player+") (card : "+card+")");
    switch (player) {
    default:
    case 1:
        spriteCards[1].texture=numberToTexture(card);
        setVisible(1,true);
        break;
    case 2:
        spriteCards[3].texture=numberToTexture(card);
        setVisible(3,true);
        break;
    case 3:
        spriteCards[5].texture=numberToTexture(card);
        setVisible(5,true);
        break;
    case 4:
        spriteCards[7].texture=numberToTexture(card);
        setVisible(7,true);
        break;
    }
}

//number : 1-8 -> guard-princess 9->verso)
function numberToTexture(number) {
    console.log("numberToTexture : (number : "+number+")");
    return ntt[number-1];
}


//numcard : 0-9 visibility : true/false
function setVisible(numcard,visibility) {
    visible[numcard]=visibility;
    if (visibility) {
        spriteCards[numcard].alpha=1;
    } else {
        spriteCards[numcard].alpha=0;
    }

}

//numcard : 0-9
function isVisible(numcard) {
    return visible[numcard];
}

function gameLoop(ms) {
    //Loop this function 60 times per second
    requestAnimationFrame(gameLoop);

    //Update the current game state:

    state(ms);
    //sprite.rotation += 0.1;
    //Render the gameScene
    TWEEN.update(ms);
    renderer.render(stage);
}

function play(ms) {



    /*for (let i=0;i<mouvements.length;i++) {
      mouvements[i].sprite.x+=mouvements[i].x;
      mouvements[i].sprite.y+=mouvements[i].y;
      }*/
}


// Converts from degrees to radians.
Math.radians = function(degrees) {
    return degrees * Math.PI / 180;
};

// Converts from radians to degrees.
Math.degrees = function(radians) {
    return radians * 180 / Math.PI;
};
