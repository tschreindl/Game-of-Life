[![Build Status](https://travis-ci.org/tschreindl/Game-of-Life.svg?branch=cleaning%2Fimprove-doc)](https://travis-ci.org/tschreindl/Game-of-Life)

# Game-of-Life
### Game of Life mit verschiedenen Regeln

Game of Life ist ein Generationen Spiel

Spielregeln (Achtung! Gilt nur für die Regeln nach Conway!):
* Eine tote Zelle mit genau drei lebenden Nachbarn wird in der nächsten Generation neu geboren
* Lebende Zellen mit weniger als zwei lebenden Nachbarn sterben in der nächsten Generation an Einsamkeit
* Eine lebende Zelle mit zwei oder drei lebenden Nachbarn bleibt in der nächsten Generation am Leben
* Lebende Zellen mit mehr als drei lebenden Nachbarn sterben in der nächsten Generation an Überbevölkerung

<br />

### Verwendung:
Projekt Klonen und folgendermaßen ausführen:
```
php gameoflife.php [option] [parameter]
```

<br />

### Folgende Optionen können beim Start benutzt werden:
```
-i oder --input    [String]   --> Legt einen Input fest der sich im Ordner "Inputs" befinden muss. z.B. RandomInput, GliderInput, etc. Standard ist RandomInput.
-o oder --output   [String]   --> Legt einen Output fest der sich im Ordner "Outputs" befinden muss. z.B. ConsoleOutput, VideoOutput, etc. Standard ist ConsoleOutput.
-r oder --rule     [String]   --> Legt eine Regel fest die sich im Ordner "Rules" befinden muss. z.B. StandardRule(Conway), CopyRule, etc. Standard ist Conway.
-w oder --width    [Integer]  --> Legt die Breite des Spielfeldes fest. Standard ist 20.
-h oder --height   [Integer]  --> Legt die Höhe des Spielfeldes fest. Standard ist 20.
-s oder --maxSteps [Integer]  --> Legt die maximale Anzahl an Schritten fest um in keine Endlos-Schleife zu geraten.
-t oder --sleepTime[Integer]  --> Legt die Pause zwischen jeder neuen Generation fest. Angabe in Sekunden. Standard ist 0.0 Sek.
-v oder --version             --> Gibt die aktuelle Version des Spieles aus.
-r oder --help                --> Gibt eine Hilfe über Parameter und Regeln aus.
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
    
--output GifOutput
    --frameTime [Integer] --> Legt die FPS (Frames per second) für die Gif Datei fest. Standard ist 10.
    
--output VideoOutput
    --noSound --> Erzeugt das Video ohne Ton. Standard ist ein Endlos-Ton.
```
(16 Standard Farben nach VGA-Palette: aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow)

<br />

### Authors
Azubi Projekt von Tim Schreindl