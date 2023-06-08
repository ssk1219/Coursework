labapp: zoomrecs.o labapp.o
	gcc -o labapp zoomrecs.o labapp.o 
zoomrecs.o: zoomrecs.c zoomrecs.h
	gcc -g -c zoomrecs.c
labapp.o: labapp.c zoomrecs.h
	gcc -g -c labapp.c
