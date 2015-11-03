"""	Lee como input un archivo .csv con header id,sub_id,comment__class,type,path,text.
	El output es un archivo .csv con header text,comment__class con la diferencia que los
	caracteres " fueron reemplazados por \" y que comment__class ahora corresponde a un string
	(antes correspondia a un int)
	"""
import sys,re,os

def usage():
	print("""
Usage:
	python 3_leave_only_text_and_class_in_the_csv.py <file_name_in>

Description:
	Lee como input un archivo .csv con header id,sub_id,comment__class,type,path,text.
	El output es un archivo .csv con header text,comment__class el cual es creado en la misma
	carpeta del archivo de input

Examples:
	python 3_leave_only_text_and_class_in_the_csv.py in.csv

		""")

try:
	filename_in_fullPath.index('/')
	os_dir_separator = '/'
except Exception:
	os_dir_separator = '\\'

filename_in_fullPath = sys.argv[1]
filename_in = os.path.basename(filename_in_fullPath) #saca el nombre con extension
filename_out_fullPath = os.path.dirname(filename_in_fullPath)+os_dir_separator+filename_in[:-4]+'_(only comments and class).csv'
filename_out = os.path.basename(filename_out_fullPath)
fdout = open(filename_out_fullPath,'w')

linesNotCorrectlyFormated = 0
with open(filename_in_fullPath) as fdin:
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