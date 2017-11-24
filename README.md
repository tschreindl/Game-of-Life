[![Build Status](https://travis-ci.org/tschreindl/Game-of-Life.svg?branch=feature%2Fphase6-pluggable-rules)](https://travis-ci.org/tschreindl/Game-of-Life)

# Game-of-Life
### Game of Life mit verschiedenen Regeln

[Game of Life](https://de.wikipedia.org/wiki/Conways_Spiel_des_Lebens) ist ein Generationen Spiel

Spielregeln (Achtung! Gilt nur für die Regeln nach Conway!):
* Eine tote Zelle mit genau drei lebenden Nachbarn wird in der nächsten Generation neu geboren
* Lebende Zellen mit weniger als zwei lebenden Nachbarn sterben in der nächsten Generation an Einsamkeit
* Eine lebende Zelle mit zwei oder drei lebenden Nachbarn bleibt in der nächsten Generation am Leben
* Lebende Zellen mit mehr als drei lebenden Nachbarn sterben in der nächsten Generation an Überbevölkerung

<br />

### Allgemein:
Das Spiel kann mit verschiedenen Inputs, Outputs und Rules gestartet werden.

* Die Inputs bieten verschiedene Möglichkeiten die erste Generation festzulegen.<br />
Es kann z.B. mit Random, einer GliderGun oder auch mit einem Tool zum selbst auswählen festgelegt werden welche Zellen beim Start am Leben sind.

* Die Outputs bieten verschiedene Möglichkeiten den Spielverlauf auszugeben.<br />
Es kann z.B. in der Console, mit einem Video oder auch als JPG/PNG ausgegeben werden.

* Die Rules legen fest, wie die nächste Generation aussieht.<br />
Es gibt z.B. die Conway-Regel, die Copy-Regel oder auch die Labyrinth-Regel.

* Die Spiel fährt solange fort, bis sich die Generationen wiederholen.<br />
Ist eine maximale Anzahl an Schritten angegeben, wird entweder wenn ALLE Zellen tot sind oder wenn die maximale Anzahl an Schritten erreicht ist, abgebrochen.

<br />

### Verwendung:
Projekt Klonen und folgendermaßen ausführen:
```
php gameoflife.php [option] [parameter]
```

<br />

### Folgende Optionen können beim Start benutzt werden:
```
-i oder --input     [String]   --> Legt einen Input fest der sich im Ordner "Inputs" befinden muss. z.B. Random, Glider, etc. Standard ist Random.
-o oder --output    [String]   --> Legt einen Output fest der sich im Ordner "Outputs" befinden muss. z.B. Console, Video, etc. Standard ist Console.
-r oder --rule      [String]   --> Legt eine Regel fest die sich im Ordner "Rules" befinden muss. z.B. Standard(Conway), Copy, etc. Standard ist Conway.
        --set-rule  [String]   --> Legt eine eigene Regel fest. Muss in "alternativer Bezeichung" angegeben werden (Wikipedia). z.B. 1357/1357 (Copy Rule).
-w oder --width     [Integer]  --> Legt die Breite des Spielfeldes fest. Standard ist 20.
-h oder --height    [Integer]  --> Legt die Höhe des Spielfeldes fest. Standard ist 20.
-s oder --maxSteps  [Integer]  --> Legt die maximale Anzahl an Schritten fest. Es wird nur abgebrochen wenn ALLE Zellen tot sind.
-t oder --sleepTime [Integer]  --> Legt die Pause zwischen jeder neuen Generation fest. Angabe in Sekunden. Standard ist 0.0 Sek.
-v oder --version              --> Gibt die aktuelle Version des Spieles aus.
        --help                 --> Gibt eine Hilfe über Parameter und Regeln aus.
```

<br />

### Bei Folgenden Optionen können weitere Parameter benutzt werden:
```
--input RandomInput 
    --fillingLVL [Integer] --> Legt fest wie viel Prozent der Felder am Leben sein sollen. Standard ist zwischen 20-80%.
    
--input GliderInput
    --PosX [Integer] --> Legt die X Startposition für den Glider fest. Standard ist in der Mitte des Feldes.
    --PosY [Integer] --> Legt die Y Startposition für den Glider fest. Standard ist in der Mitte des Feldes.
    
--output ConsoleOutput
    --cmd --> Ausgabe wird angepasst wenn Ausgabe über CMD/Terminal. Standard ist False.
    
--output GifOutput|PNGOutput|JPEGOutput|VideoOutput
    --cellSize  [Integer] --> Ändert die Zellgröße. Standard ist 40px
    --cellColor [String]  --> Ändert die Zellfarbe. Im Format R,G,B oder #HEX oder Standard Farbe. Standard ist Gelb.
    --bkColor   [String]  --> Ändert die Hintergrundfarbe. Im Format R,G,B oder #HEX oder Standard Farbe. Standard ist Grau.
    --lineColor [String]  --> Ändert die Farbe des Gitternetz. Im Format R,G,B oder #HEX oder Standard Farbe. Standard ist Weiß.
    
--output GifOutput
    --frameTime [Integer] --> Legt die FPS (Frames per second) für die Gif Datei fest. Standard ist 10.
    
--output VideoOutput
    --noSound --> Erzeugt das Video ohne Ton. Standard ist ein Endlos-Ton.
```
(16 Standard Farben nach VGA-Palette: aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow)

<br />

### Authors
Azubi Projekt von Tim Schreindl