<?php

// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=parks_db', 'parks_user', 'parks');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//add query to delete all records from db
$dbc->exec('TRUNCATE national_parks');

//parks info as array
$parks = [
    ['name' => 'Acadia', 'location' => 'Maine', 'date_established' => '1919-02-26', 'area_in_acres' => 47389.67, 'description' => 'Covering most of Mount Desert Island and other coastal islands, Acadia features the tallest mountain on the Atlantic coast of the United States, granite peaks, ocean shoreline, woodlands, and lakes. There are freshwater, estuary, forest, and intertidal habitats.'],
    ['name' => 'American Samoa', 'location' => 'American Samoa', 'date_established' => '1988-10-31', 'area_in_acres' => 9000.00, 'description' => 'The southernmost national park is on three Samoan islands and protects coral reefs, rainforests, volcanic mountains, and white beaches. The area is also home to flying foxes, brown boobies, sea turtles, and 900 species of fish.'],
    ['name' => 'Arches', 'location' => 'Utah', 'date_established' => '1929-04-12', 'area_in_acres' => 76518.98, 'description' => 'This site features more than 2,000 natural sandstone arches, including the famous Delicate Arch. In a desert climate, millions of years of erosion have led to these structures, and the arid ground has life-sustaining soil crust and potholes, which serve as natural water-collecting basins. Other geologic formations are stone columns, spires, fins, and towers.'],
    ['name' => 'Badlands', 'location' => 'South Dakota', 'date_established' => '1978-11-10', 'area_in_acres' => 242755.94, 'description' => 'The Badlands are a collection of buttes, pinnacles, spires, and grass prairies. It has the world\'s richest fossil beds from the Oligocene epoch, and the wildlife includes bison, bighorn sheep, black-footed ferrets, and swift foxes.'],
    ['name' => 'Big Bend', 'location' => 'Texas', 'date_established' => '1944-06-12', 'area_in_acres' => 801163.21, 'description' => 'Named for the prominent bend in the Rio Grande along the US–Mexico border, this park encompasses a large and remote part of the Chihuahuan Desert. Its main attraction is backcountry recreation in the arid Chisos Mountains and in canyons along the river. A wide variety of Cretaceous and Tertiary fossils as well as cultural artifacts of Native Americans also exist within its borders.'],
    ['name' => 'Biscayne', 'location' => 'Florida', 'date_established' => '1980-06-28', 'area_in_acres' => 172924.07, 'description' => 'Located in Biscayne Bay, this park at the north end of the Florida Keys has four interrelated marine ecosystems: mangrove forest, the Bay, the Keys, and coral reefs. Threatened animals include the West Indian manatee, American crocodile, various sea turtles, and peregrine falcon.'],
    ['name' => 'Black Canyon of the Gunnison', 'location' => 'Colorado', 'date_established' => '1999-10-21', 'area_in_acres' => 32950.03, 'description' => 'The park protects a quarter of the Gunnison River, which slices sheer canyon walls from dark Precambrian-era rock. The canyon features incredibly steep descents, and is a popular site for river rafting and rock climbing. The deep, narrow canyon, made of gneiss and schist, is often in shadow and therefore appears black.'],
    ['name' => 'Bryce Canyon', 'location' => 'Utah', 'date_established' => '1928-02-25', 'area_in_acres' => 35835.08, 'description' => 'Bryce Canyon is a giant geological amphitheater on the Paunsaugunt Plateau. The unique area has hundreds of tall sandstone hoodoos formed by erosion. The region was originally settled by Native Americans and later by Mormon pioneers.'],
    ['name' => 'Canyonlands', 'location' => 'Utah', 'date_established' => '1964-09-12', 'area_in_acres' => 337597.83, 'description' => 'This landscape was eroded into a maze of canyons, buttes, and mesas by the combined efforts of the Colorado River, Green River, and their tributaries, which divide the park into three districts. There are rock pinnacles and other naturally sculpted rock formations, as well as artifacts from Ancient Pueblo peoples.'],
    ['name' => 'Capitol Reef', 'location' => 'Utah', 'date_established' => '1971-12-18', 'area_in_acres' => 241904.26, 'description' => 'The park\'s Waterpocket Fold is a 100-mile (160 km) monocline that exhibits the earth\'s diverse geologic layers. Other natural features are monoliths, sandstone domes, and cliffs shaped like the United States Capitol.'],
    ['name' => 'Carlsbad Caverns', 'location' => 'New Mexico', 'date_established' => '1930-05-14', 'area_in_acres' => 46766.45, 'description' => 'Carlsbad Caverns has 117 caves, the longest of which is over 120 miles (190 km) long. The Big Room is almost 4,000 feet (1,200 m) long, and the caves are home to over 400,000 Mexican free-tailed bats and sixteen other species. Above ground are the Chihuahuan Desert and Rattlesnake Springs.'],
    ['name' => 'Channel Islands', 'location' => 'California', 'date_established' => '1980-03-05', 'area_in_acres' => 249561.00, 'description' => 'Five of the eight Channel Islands are protected, and half of the park\'s area is underwater. The islands have a unique Mediterranean ecosystem originally settled by the Chumash people. They are home to over 2,000 species of land plants and animals, and 145 are unique to them, including the island fox. Professional ferry services offer transportation to the islands from the mainland.'],
    ['name' => 'Congaree', 'location' => 'South Carolina', 'date_established' => '2003=11-10', 'area_in_acres' => 26545.86, 'description' => 'On the Congaree River, this park is the largest portion of old-growth floodplain forest left in North America. Some of the trees are the tallest in the Eastern US. An elevated walkway called the Boardwalk Loop guides visitors through the swamp.'],
    ['name' => 'Crater Lake', 'location' => 'Oregon', 'date_established' => '1902-05-22', 'area_in_acres' => 183224.05, 'description' => 'Crater Lake lies in the caldera of an ancient volcano called Mount Mazama that collapsed 7,700 years ago. It is the deepest lake in the United States and is famous for its vivid blue color and water clarity. There are two more recent volcanic islands in the lake, and, with no inlets or outlets, all water comes through precipitation.'],
    ['name' => 'Cuyahoga Valley', 'location' => 'Ohio', 'date_established' => '2000-10-11', 'area_in_acres' => 32950, 'description' => 'This park along the Cuyahoga River has waterfalls, hills, trails, and exhibits on early rural living. The Ohio and Erie Canal Towpath Trail follows the Ohio and Erie Canal, where mules towed canal boats. The park has numerous historic homes, bridges, and structures, and also offers a scenic train ride.'],
    ['name' => 'Death Valley', 'location' => 'California, Nevada', 'date_established' => '1994-10-31', 'area_in_acres' => 3372401.96, 'description' => 'Death Valley is the hottest, lowest, and driest place in the United States. Daytime temperatures have topped 130 °F (54 °C) and it is home to Badwater Basin, the lowest elevation in North America. A diversity of colorful canyons, desolate badlands, shifting sand dunes, sprawling mountains, and over 1000 species of plants populate this geologic graben. Additional points of interest include salt flats, historic mines, and springs.'],
    ['name' => 'Denali', 'location' => 'Alaska', 'date_established' => '1917-02-26', 'area_in_acres' => 4740911.72, 'description' => 'Centered around Denali, the tallest mountain in North America, Denali is serviced by a single road leading to Wonder Lake. Denali and other peaks of the Alaska Range are covered with long glaciers and boreal forest. Wildlife includes grizzly bears, Dall sheep, caribou, and gray wolves.'],
];

$stmt = $dbc->prepare('INSERT INTO national_parks (name, location, date_established, area_in_acres, description) 
                        VALUES (:name, :location, :date_established, :area_in_acres, :description)');

//insert info for parks as array of data
foreach ($parks as $park) {
    $stmt->bindValue(':name', $park['name'], PDO::PARAM_STR);
    $stmt->bindValue(':location', $park['location'], PDO::PARAM_STR);
    $stmt->bindValue(':date_established', $park['date_established'], PDO::PARAM_STR);
    $stmt->bindValue(':area_in_acres', $park['area_in_acres'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $park['description'], PDO::PARAM_STR);
    $stmt->execute();
}





?>