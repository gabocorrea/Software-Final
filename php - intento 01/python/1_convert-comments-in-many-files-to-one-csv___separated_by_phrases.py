"""


if len(sys.argv)<=1:
	print('\nUsage: csv2arff_REAL_accepts_any_csv.py <input.csv> type1 type2 type3 ...\n')
	sys.exit()

with open(sys.argv[1]) as filein:

	"""
import sys, os, getopt

def usage():
	print('''
Reads all .java files inside a folder (recursively to inside folders), and adds each javadoc comment
to a .csv file that is created, but the comments are separated by the phrases that form the whole comment.
.java files inside that folder must be in a specific format, which is the same format that outputs
the script slocc.sh

Usage: python 1_convert-comments-in-many-files-to-one-csv___separated_by_phrases
	     <folder_with_comments>
	     <file_name>
	     [OPTIONS]

Options:
	-h, --help
		print help and usage of this script

	-c, --classifier
		Must be NONE or KEYWORDS. If NONE, phrases won't be given a color (or a type of comment).
		If KEYWORDS, phrases with at least one keyword - see keywords below - will be given a yellow color (directive-type comment).
		NONE is the default if option is left blank.

		keywords:
			call*,invo*,before,after,between,once,prior,must,mandat*,require*,shall,
			should,encourage*,recommend*,may,assum*,only,debug*,restrict*,never,
			condition*,strict*,necessar*,portab*,strong*,performan*,efficien*,fast,
			quick,better,best,concurren*,synchron*,lock*,thread*,simultaneous*,
			desir*,alternativ*,addition*,extend*,overrid*,overload*,overwrit*,
			reimplement*,subclass*,super*,inherit*,warn*,aware*,error*,note*
			
Examples:
	python 1_convert-comments-in-many-files-to-one-csv___separated_by_phrases folderIn out.csv -c KEYWORDS
	python 1_convert-comments-in-many-files-to-one-csv___separated_by_phrases folderIn out.csv
			''')
if len(sys.argv)<3:
	print('this needs at least 2 arguments!')
	usage()
	sys.exit(2)

usrinput = {}
usrinput['in']=sys.argv[1]
usrinput['out']=sys.argv[2]

try:
	opts, restargs = getopt.getopt(sys.argv[1:], 'c:h', ['classifier=','help]'])
except getopt.GetoptError:
	usage()
	sys.exit(2)


for opt, arg in opts:
	if opt in ('-h','--help'):
		usage()
		sys.exit(2)
	elif opt in ('-c','--classifier'):
		usrinput['classifier']=arg


def getJavadocCommentsListFromFile(filepath):
    with open(os.path.join(root, name)) as fdin:
		filecontent = fdin.read()
		########################################!!!!!!!!!!!!!!!!!!!! TODO !  falta sacar el texto entre /**   */ (excluyendo * y tabs internos y cuidado con los newlines)

listofcomments=[]
for root, dirs, files in os.walk(usrinput['in'], topdown=True):
    for name in files:
        print(os.path.join(root, name))