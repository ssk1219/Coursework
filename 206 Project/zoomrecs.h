// Node Structure

#ifndef ZOOMRECORDH
#define ZOOMRECORDH
struct ZoomRecord
{
	char email[60]; // email of the student
	char name[60]; // name of the student
	int durations[9]; // duration for each lab.
	struct ZoomRecord *next;
};
struct ZoomRecord* addZoomRecord(struct ZoomRecord *headptr, char *data);
void generateAttendance(struct ZoomRecord *headptr, FILE *out);
#endif
