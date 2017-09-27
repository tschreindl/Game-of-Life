[![Build Status](https://travis-ci.org/tschreindl/Game-of-Life.svg?branch=feature%2Fphase5)](https://travis-ci.org/tschreindl/Game-of-Life)

# Game-of-Life
### Game of Life mit Conways Regeln

Conways Game of Life ist ein Generationen Spiel
Spielregeln:
* Eine tote Zelle mit genau drei lebenden Nachbarn wird in der Folgegeneration neu geboren
* Lebende Zellen mit weniger als zwei lebenden Nachbarn sterben in der Folgegeneration an Einsamkeit
* Eine lebende Zelle mit zwei oder drei lebenden Nachbarn bleibt in der Folgegeneration am Leben
* Lebende Zellen mit mehr als drei lebenden Nachbarn sterben in der Folgegeneration an Überbevölkerung

<br />

##### Verwendung:
Projekt Klonen und folgendermaßen ausführen:
```
php gameoflife.php [option] [parameter]
```

<br />

##### Folgende Optionen können beim Start benutzt werden:
```
-i oder --input [String]--> Legt einen Input fest der sich im Ordner "Inputs" befinden muss. Z.b RandomInput, GliderInput, etc. Standard ist RandomInput.
-w oder --width [Integer] --> Legt die Breite des Spielfeldes fest. Standard ist 20.
-h oder --height [Integer] --> Legt die Höhe des Spielfeldes fest. Standard ist 20.
-s oder --maxSteps [Integer] --> Legt die maximale Anzahl an Schritten fest um in keine Endlos-Schleife zu geraten.
-v oder --version --> Gibt die aktuelle Version des Spieles aus.
-r oder --help --> Gibt eine Hilfe über Parameter und Regeln aus.
```

<br />

##### Bei Folgenden Optionen können weitere Parameter benutzt werden:
```
--input RandomInput 
    --fillingLVL [Integer] --> Legt fest wie viel Prozent der Felder am Leben sein sollen. Standard ist zwischen 20-80%.
    
--input GliderInput
    --PosX [Integer] --> Legt die X Startposition für den Glider fest. Standard ist in der Mitte des Feldes.
    --PosY [Integer] --> Legt die Y Startposition für den Glider fest. Standard ist in der Mitte des Feldes.
    
--output ConsoleOutput
    --cmd --> Ausgabe wird angepasst wenn Ausgabe über CMD/Terminal. Standard ist False.
    
--output GifOutput|PNGOutput|JPEGOutput|VideoOutput
    --cellSize [Integer] --> Ändert die Zellgröße. Standard ist 40px
    --cellColor [Integer,Integer,Integer] --> Ändert die Zellfarbe. Im Format R,G,B oder #HEX oder Standard Farbe. Standard ist Gelb.
    --bkColor [Integer,Integer,Integer] --> Ändert die Hintergrundfarbe. Im Format R,G,B oder #HEX oder Standard Farbe. Standard ist Grau.
    
--output GifOutput
    --frameTime [Integer] --> Legt die FPS (Frames per second) für die Gif Datei fest. Standard ist 10.
    
--output VideoOutput
    --noSound --> Erzeugt das Video ohne Ton. Standard ist ein Endlos-Ton.
```

<br />
<br />

##### Authors
Azubi Projekt von Tim Schreindl