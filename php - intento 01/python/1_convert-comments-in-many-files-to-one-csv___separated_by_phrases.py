#!/usr/bin/env python
import sys, os, getopt, re, collections

def usage():
	print('''
Usage:
	python 1_convert-comments-in-many-files-to-one-csv___separated_by_phrases
		<folder_with_comments>
		<file_name>
		[OPTIONS]

Description:
	Reads all .java files inside a folder (recursively to inside folders), and adds each javadoc comment
	to a .csv file that is created, but the comments are separated by the phrases that form the whole comment.
	.java fioles inside that flder must be in a specific format, which is the same format that outputs
	the script slocc.sh

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

	-m, --minlines
		Sets the minimum lines a javadoc comment nees to have in ordered to be included in the output file.
		(IMPORTANT:)By default is 4. For example, the following javadoc comment has 4 lines:
			/** Returns a {@link Set} of unique elements in the Bag.
			 * 
			 * @return the Set of unique Bag elements
			 */
			
Examples:
	python 1_convert-comments-in-many-files-to-one-csv___separated_by_phrases folderIn out.csv
	python 1_convert-comments-in-many-files-to-one-csv___separated_by_phrases folderIn out.csv -c KEYWORDS
	python 1_convert-comments-in-many-files-to-one-csv___separated_by_phrases folderIn out.csv -c KEYWORDS --minlines=3
	
Details:
	The output .csv file has the following header:
		id,sub_id,is_directive,type,path,text
			''')



# User Input:
if len(sys.argv)<3:
	print('this needs at least 2 arguments!')
	usage()
	sys.exit(2)

usrinput = {}
try:
	opts, restargs = getopt.getopt(sys.argv[1:],'c:m:h',['classifier=','minlines=','help'])
except getopt.GetoptError:
	usage()
	sys.exit(2)

for opt, arg in opts:
	if opt in ('-h','--help'):
		usage()
		sys.exit(2)
	elif opt in ('-c','--classifier'):
		usrinput['classifier']=arg
	elif opt in ('m','--minlines'):
		usrinput['minlines']=arg
if len(restargs)==2:
	usrinput['in']=restargs[0]
	usrinput['out']=restargs[1]
else:
	usage()
	sys.exit(2)





	
# Defaults:
if 'minlines' in usrinput.keys():
	COMMENT_MINIMUM_LINES = usrinput['minlines']
else:
	COMMENT_MINIMUM_LINES = 4

if 'classifier' in usrinput.keys():
	CLASSIFIER = usrinput['classifier']
else:
	CLASSIFIER = 'NONE'


















def getJavadocCommentsListFromFile(filepath):
	ret=[]
	with open(os.path.join(root, name)) as fdin:
		filecontent = fdin.read()
		
		#Saco cada comentario tipo javadoc y lo agrego a una lista, la cual sera retornada por la funcion
		# busco /**  (eso abre el javadoc)  y termina en */ ... voy a sacar el string de entre medio
		# pero, saco los '     * ' que hay en cada otra linea (ver algun archivo de ejemplo para entender esto ultimo)
		i=0
		num=0
		while i<len(filecontent) or num<10:
			num+=1
			last_i = i
			try:
				i = filecontent.index('/**',i)
			except ValueError:
				return ret
			try:
				k = filecontent.rindex('//',last_i,i)
				try:
					nl = filecontent.rindex('\n',last_i,i)
					if nl<k: # si ocurre por ejemplo esta linea:   \n //   /** soy un javadoc adentro de in-line comments \n */
						i = i+3
						continue
				except ValueError: #esto sucede solo si en la 1ra linea de archivo hay:  //  /** javadoc en la linea 1 \n ...
					i = i+3
					continue
			except ValueError:
				pass
			try:
				f = filecontent.index('*/',i+3)
			except ValueError:
				i = i+3
				continue#this can only happen with a comment of this form: '/**/' (otherwise, that .py file wouldn't even run/compile)
				    #so we ignore this case: we don't append it to the output list
			commentString = filecontent[i+3:f]
			commentLineCount = commentString.count('\n') + 1
			if commentLineCount>=COMMENT_MINIMUM_LINES:
				newCommentString = re.sub(r'(\n\s+)\*', r'\1', commentString) #esto le saca los molestos   * al ppio de cada linea del javadoc
				newCommentString = re.sub(r'\n', r'\\n', newCommentString) #esto hace que el comentario no sea multilinea, reemplazando sus newlines por \\n
				ret.append(newCommentString)
			i = f+2
		raise Exception('Error. Something went wrong.')
		sys.exit(2)

dictOfComments = collections.OrderedDict() # a dictionary that contain lists of comments. each list corresponds to a file
for root, dirs, files in os.walk(usrinput['in'], topdown=True):
	for name in files:
		path = os.path.join(root,name)
		dictOfComments[path] = getJavadocCommentsListFromFile( path )












# Function that tries to guess the class of a comment
# It can use the Monperrus-Keywords (param --classifier=KEYWORDS) classifier or no classifier (param --classifier=NONE)
def getCommentClass(text, classifierStr):
	if classifierStr=='NONE':
		return 0
	elif classifierStr=='KEYWORDS':
		raise Exception('Error. --classifier=KEYWORDS option hasn\'t been implemented yed.')
















# Needed to separate phrases:
regexEnd = r'\.\s*(&nbsp;)*(<br>)*\s*(&nbsp;)*(\\n)+\s*(&nbsp;)*(<br>)*\s*(&nbsp;)*(\\n)*|\.\s+|</ul>\s*(\\n)*\s*|</ol>\s*(\\n)*\s*|</dl>\s*(\\n)*\s*'
regexBeg = r'@param|@return|@deprecated|@exception|@throws|@see|@version|@since|@author|<li>|<dd>'
pEnd = re.compile(regexEnd,re.IGNORECASE)
pBeg = re.compile(regexBeg,re.IGNORECASE)


# escribir output a un archivo:
with open(usrinput['out'],'w') as fdout:
	fdout.write('id,sub_id,is_directive,type,path,text\n')
	idnum=1
	for key,listWithComments in dictOfComments.items():
		path=key
		for astring in listWithComments:


			# Separate to phrases:

			splitPositionsList = []

			iteratorEnd = pEnd.finditer(astring)
			for m in iteratorEnd:
				splitPositionsList.append( m.end() )

			iteratorBeg = pBeg.finditer(astring)
			for m in iteratorBeg:
				splitPositionsList.append( m.start() )

			splitPositionsList.sort()

			nextStartPos=0
			j=1
			fdout.write('{0},{1},0,dummy_type,{2},{3}\n'.format(idnum,0,path,astring)) #el sub_id==0 tiene el comentario completo original
			for pos in splitPositionsList:
				theText = astring[nextStartPos:pos]
				if len(theText)>=1:
					outstr = '{0},{1},{2},dummy_type,{3},{4}\n'.format(idnum,j,getCommentClass(theText,usrinput['classifier']),path,theText)
					if pos<len(astring):
						outstr += ""
					elif pos>len(astring):
						raise Exception('Error. Something shouldn\'t have happened')
						sys.exit(2)
					fdout.write(outstr)
					j+=1
				nextStartPos=pos
				
			theText = astring[nextStartPos:]
			if nextStartPos<len(astring) and len(theText)>=1:
				outstr = '{0},{1},{2},dummy_type,{3},{4}\n'.format(idnum,j,getCommentClass(theText,usrinput['classifier']),path,theText)

			
			idnum+=1