<?
$data = Array
(
	'game' => Array
		(
			'width' => 800,
			'height' => 800,
			'function' => Array
				(
					'preload' => 'preload',
					'create' => 'create',
					'update' => 'update',
					'render' => 'render',
				),
		),
	'objects' => Array
		(
			'cursor' => Array
				(
					'cursors' => Array // create cursor
						(
						),
				),
			'tilesmap' => Array
				(
					'map' => Array
						(
							'asset' => 'assets/features_test.json',
						),
				),
			'sprites' => Array
				(
					'sprite' => Array //game.load.spritesheet
						(
							'spritesheet_name' => 'phaser',
							'asset' => 'assets/dude.png',
							'width' => 32,
							'height' => 48,
							'animations' => Array
								(
									'left' => Array
										(
											'frames' => '[0, 1, 2, 3]',
											'fps' => 10,
											'loop' => true
										),
									'right' => Array
										(
											'frames' => '[5, 6, 7, 8]',
											'fps' => 10,
											'loop' => true
										),
								),
						),
					'coin' => Array
						(
							'spritesheet_name' => 'coin',
							'asset' => 'assets/coin.png',
							'width' => 32,
							'height' => 32
						),
					'questBox' => Array //game.load.image
						(
							'asset' => 'assets/box.jpg',
						),
					'ground_1x1' => Array
						(
							'asset' => 'assets/ground_1x1.png',
						),
					'walls_1x2' => Array
						(
							'asset' => 'assets/walls_1x2.png',
						),
					'tiles2' => Array
						(
							'asset' => 'assets/tiles2.png',
						),
				),
			'text' => Array
				(
					'scoreText' => Array
						(
							'fontsize' => 18,
							'color' => '#fff',
							'text' => 'Score',
							'pos' => Array
								(
									'x' => 16,
									'y' => 10,
								),
						),
					'correctText' => Array
						(
							'fontsize' => 18,
							'color' => '#fff',
							'text' => 'Correct',
							'pos' => Array
								(
									'x' => 16,
									'y' => 40,
								),
						),
					'questText' => Array
						(
							'fontsize' => 28,
							'color' => '#222',
							'text' => 'Quest',
							'pos' => Array
								(
									'x' => 160,
									'y' => 160,
								),
						),
				),
			'variables' => Array
				(
					'score' => 0,
					'correct' => 0,
					'frozen' => 'false',
				),
			'layers' => Array
				(
					'layer' => Array
						(
							'name' => 'Tile Layer 1',
							'pid' => 'map', // layer = map.createLayer('Tile Layer 1');
						),
				),
		),


	'groups' => Array
		(
			'coins' => Array
				(
					'enableBody' => true,
				),
		),


	'events' => Array
		(
			'system' => Array
				(
					'setPhysics' => 'ARCADE',
				),
			'objects' => Array
				(
					'sprites' => Array
						(
							'sprite' => Array
								(
									'enablePhysics' => Array
										(
										),
									'bounce' => Array
										(
											'y' => 0.2,
										),
									'gravity' => Array
										(
											'y' => 300,
										),
									'collide' => Array
										(
											'layer' => Array // collide with layer
												(
												),
											'coins' => Array // collide with coins
												(
													'callback' => 'collectCoin',
												),
										),
/*									'property' => Array
										(
											'bounce.y' => 0.2,
											'gravity.y' => 300,
											'collideWorldBounds' => true,
										), */
								),
						),
					'layers' => Array
						(
							'layer' => Array
								(
									'resizeWorld' => '',
								),
						),
					'tilesmap' => Array 
						(
							'map' => Array
								(
									'addTilesetImage' => Array
										(
											'ground_1x1',
											'walls_1x2',
											'tiles2',
										),
									'setCollisionBetween' => Array (1, 12),
									'createFromObjects' => Array
										(
											'name' => 'Object Layer 1',
											'tilesID' => 34,
											'objName' => 'coin',
											'group' => 'coins',
										),
								),
						),
					'cursor' => Array 
						(
							'cursors' => Array
								(
									'if' => Array
										(
											'left' => Array 
												(
													'isDown' => '',
													'then' => Array
														(
															'objects' => Array
																(
																	'sprite' => Array // sprite do
																		(
																			'setx' => Array
																				(
																					'x' => -150
																				),
																			'setAnimation' => Array
																				(
																					'x' => 'left',
																				),
																		),
																),
														),
												),
										),
								),
						),
				),
			'groups' => Array
				(
					'coins' => Array
						(
						),
				),
			'functions' => Array 
				(
					'collectCoin' => Array
						(
							'paramemters' => Array // collectCoin (player, coin)
								(
									'player',
									'coin'
								),
							'do' => Array
								(
									
								),
						)
				),
		),
);

//print_r($data);

//echo json_encode($data);
