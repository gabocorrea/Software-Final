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
	ret=[]
    with open(os.path.join(root, name)) as fdin:
		filecontent = fdin.read()
		
		#Saco cada comentario tipo javadoc y lo agrego a una lista, la cual sera retornada por la funcion
		# busco /**  (eso abre el javadoc)  y termina en */ ... voy a sacar el string de entre medio
		# pero, saco los '     * ' que hay en cada otra linea (ver algun archivo de ejemplo para entender esto ultimo)
		while i<len(filecontent):
			try:
				i = filecontent.index('/**')
			except ValueError:
				return ret
			try:
				f = filecontent.index('*/',i+3)
			except ValueError:
				i = i+3
				continue#this can only happen with a comment of this form: '/**/' (otherwise, that .py file wouldn't even run/compile)
				    #so we ignore this case: we don't append it to the output list
			ret.append(filecontent[i+3:f])
			i = f+2
		print('code shouldn\'t have reached this line')
		sys.exit(2)


listofcomments=[]
for root, dirs, files in os.walk(usrinput['in'], topdown=True):
    for name in files:
        listofcomments.extend(getJavadocCommentsListFromFile( os.path.join(root, name) ) )

with open(usrinput['out']) as fdout:
	fdout.write('id,type,path,text\n')
	idnum=1
	for astring in listofcomments:
		fdout.write('{0},dummy_type,dummy_path,{1}\n'.format(idnum,astring))
		idnum+=1

#TODO: idnum es el id... pero falta el sub_id....entonces la lista listofcomments tiene que ser lista de lista para calcular
#      el sub_id.  IMPORTANTEEEE :---> falta tambien calcular el path de cada archivo! quizas haya que hacer un dict en vez de la lista 
#      listof comments