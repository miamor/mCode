var game = new Phaser.Game(800, 600, Phaser.AUTO, 'phaser-example', { preload: preload, create: create, update: update, render: render });

var cursors;
var map;
var coins;

var layer;
var sprite;

var score = 0;
var scoreText;
var correct = 0;
var quest;
var questText;
var questBox;
var frozen = false;

function preload() {

	game.load.image('questBox', 'assets/box.jpg');
	game.load.tilemap('map', 'assets/features_test.json', null, Phaser.Tilemap.TILED_JSON);

	game.load.image('ground_1x1', 'assets/ground_1x1.png');
	game.load.image('walls_1x2', 'assets/walls_1x2.png');
	game.load.image('tiles2', 'assets/tiles2.png');

	game.load.spritesheet('phaser', 'assets/dude.png', 32, 48);
	game.load.spritesheet('coin', 'assets/coin.png', 32, 32);

}

function create() {

	game.physics.startSystem(Phaser.Physics.ARCADE);

	map = game.add.tilemap('map');

	map.addTilesetImage('ground_1x1');
	map.addTilesetImage('walls_1x2');
	map.addTilesetImage('tiles2');

	map.setCollisionBetween(1, 12);

	layer = map.createLayer('Tile Layer 1');

	layer.resizeWorld();

	//  Here we create our coins group
	coins = game.add.group();
	coins.enableBody = true;

	//  And now we convert all of the Tiled objects with an ID of 34 into sprites within the coins group
	map.createFromObjects('Object Layer 1', 34, 'coin', 0, true, false, coins);

	//  Add animations to all of the coin sprites
	coins.callAll('animations.add', 'animations', 'spin', [0, 1, 2, 3, 4, 5], 10, true);
	coins.callAll('animations.play', 'animations', 'spin');

//	sprite = game.add.sprite(260, 100, 'phaser');
	sprite = game.add.sprite(32, game.world.height - 150, 'phaser');
//	sprite.anchor.set(0.5);
	game.physics.enable(sprite);

//	sprite.body.setSize(16, 16, 8, 8);

	//  sprite physics properties. Give the little guy a slight bounce.
	sprite.body.bounce.y = 0.2;
	sprite.body.gravity.y = 300;
	sprite.body.collideWorldBounds = true;

	//  Our two animations, walking left and right.
	sprite.animations.add('left', [0, 1, 2, 3], 10, true);
	sprite.animations.add('right', [5, 6, 7, 8], 10, true);

	game.camera.follow(sprite);

	cursors = game.input.keyboard.createCursorKeys();

	//  The score
	scoreText = game.add.text(16, 10, 'Score: 0', { fontSize: '18px', fill: '#fff' });
	scoreText.fixedToCamera = true;
	//  The correct
	correctText = game.add.text(16, 40, 'Correct: 0', { fontSize: '18px', fill: '#fff' });
	correctText.fixedToCamera = true;

}

function collectCoin(player, coin) {

	frozen = true;
	
	newQuest(coin);

}

function update() {

	game.physics.arcade.collide(sprite, layer);
	game.physics.arcade.overlap(sprite, coins, collectCoin, null, this);

	sprite.body.velocity.x = 0;
//	sprite.body.velocity.y = 0;
//	sprite.body.angularVelocity = 0;

	if (frozen == false) {
		if (cursors.left.isDown)
		{
			//  Move to the left
			sprite.body.velocity.x = -150;

			sprite.animations.play('left');
		}
		else if (cursors.right.isDown)
		{
			//  Move to the right
			sprite.body.velocity.x = 150;

			sprite.animations.play('right');
		}
		else
		{
			//  Stand still
			sprite.animations.stop();
			sprite.frame = 4;
		}
		
		//  Allow the sprite to jump if they are touching the ground.
		if (cursors.up.isDown)
		{
			if (sprite.body.onFloor())
			{
				sprite.body.velocity.y = -250;
			}
		}
	} else {
		sprite.animations.stop();
		sprite.frame = 4;
	}

}

function render() {

//	game.debug.body(sprite);

}
