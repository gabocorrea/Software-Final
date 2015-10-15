"""	Lee como input un archivo .csv con header id,sub_id,comment__class,type,path,text.
	El output es un archivo .csv con header text,comment__class con la diferencia que los
	caracteres " fueron reemplazados por \" y que comment__class ahora corresponde a un string
	(antes correspondia a un int)
	"""
import sys,re

def usage():
	print("""
Usage:
	python 3_leave_only_text_and_class_in_the_csv.py <file_name_in>

Description:
	Lee como input un archivo .csv con header id,sub_id,comment__class,type,path,text.
	El output es un archivo .csv con header text,comment__class

Examples:
	python 3_leave_only_text_and_class_in_the_csv.py in.csv

		""")



filename_in=sys.argv[1]
fdout = open(filename_in[:-4]+'_(only comments and class).csv','w')

linesNotCorrectlyFormated = 0
with open(filename_in) as fdin:
	i=0
	for line in fdin:
		splitted = line.split(',',5)
		if len(splitted) == 6:
			if i<=0:
				fdout.write(splitted[5][:-1]+','+splitted[2]+'\n')
			else:
				#p=re.compile(r'"')
				#s=p.sub( r'\"', splitted[5])
				s = splitted[5]
				s=s[:-1]
				fdout.write(s+',')
				if(splitted[2]=='0'):
					fdout.write('non-directive\n')
				elif(splitted[2]=='1'):
					fdout.write('directive\n')
				elif(splitted[2]=='2'):
					fdout.write('directive\n')#('minor-directive\n')
				elif(splitted[2]=='3'):
					fdout.write('directive\n')#('null-directive\n')
				else:
					print('Error, read a number out of range in the directive types')
					sys.exit()
		else:
			linesNotCorrectlyFormated += 1
		i+=1

print('linesNotCorrectlyFormated='+str(linesNotCorrectlyFormated))