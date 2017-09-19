[![Build Status](https://travis-ci.org/tschreindl/Game-of-Life.svg?branch=feature%2Fphase5)](https://travis-ci.org/tschreindl/Game-of-Life)

# Game-of-Life
###Game of Life mit Conways Regeln

Conways Game of Life ist ein Generationen Spiel
Spielregeln:
* Eine tote Zelle mit genau drei lebenden Nachbarn wird in der Folgegeneration neu geboren
* Lebende Zellen mit weniger als zwei lebenden Nachbarn sterben in der Folgegeneration an Einsamkeit
* Eine lebende Zelle mit zwei oder drei lebenden Nachbarn bleibt in der Folgegeneration am Leben
* Lebende Zellen mit mehr als drei lebenden Nachbarn sterben in der Folgegeneration an Überbevölkerung


Folgende Parameter können beim Start benutzt werden:
* -i oder --input --> Legt einen Input fest der sich im Ordner "Inputs" befinden muss. Z.b Random, Glider, etc. Standard ist Random.
* -w oder --width --> Legt die Breite des Spielfeldes fest. Standard ist 10.
* -h oder --hight --> Legt die Höhe des Spielfeldes fest. Standard ist 10.
* -s oder --maxSteps --> Legt die maximale Anzahl an Schritten fest um in keine Endlos-Schleife zu geraten.
* -v oder --version --> Gibt die aktuelle Version des Spieles aus.
* -r oder --help --> Gibt eine Hilfe über Parameter und Regeln aus.


Bei Folgenden Parametern können weitere Parameter benutzt werden:
* --input Random --fillingLVL --> Legt fest wie viel Prozent der Felder am Leben sein sollen. Standard ist zwischen 20-80%.
* --input Glider --PosX <zahl> --PosY <zahl> --> Legt eine Startposition für den Glider fest. Standard ist in der Mitte des Feldes.
