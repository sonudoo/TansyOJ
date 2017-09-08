# This script is the heart of the judge.

import pymysql,os,subprocess,time,socket,re,pwd
host = "127.0.0.1" #The judge runs locally
port = 8080 #Port on which the will listen
mySocket = socket.socket()
mySocket.bind((host,port))
judgeOnce = True #This will make the judge skip the wait phase and judge all unjudged submissions
ojid = pwd.getpwnam('oj').pw_uid
rootid = pwd.getpwnam('root').pw_uid

# Replace the below fields with corresponding correct values.

dbserver = "database_server_here"
username = "database_username_here"
password = "database_password_here"
database = "database_name_here"


# This function is used to create a new directory named Cell inside which all submissions will be compiled and run.
# This function is common for all languages.

def gainPermissions():
	try:
		if(os.path.isdir("Cell")==False):
			os.system("mkdir Cell")
	except:
		return -1
	return 0

# This function is used to create the corresponding C++ file from the submission.
# This function is specific to C++

def fetchCPPCode(code):
	try:
		file = open("Cell/Program.cpp","w+")
		file.write(code)
		file.close()
	except:
		return -1
	return 0

# This function is used to create the corresponding Java file from the submission.
# This function is specific to Java

def fetchJavaCode(code):
	try:
		file = open("Cell/Main.java","w+")
		file.write(code)
		file.close()
	except:
		return -1
	return 0


# This function is used to compile the C++ file
# This function is specific to C++

def compileCPP():
	try:
		file = "Cell/Program.cpp"
		c = subprocess.Popen(["g++",file,"-o","Cell/Program","-std=c++14"],stdout=subprocess.PIPE,stderr=subprocess.PIPE)

		output = "Compilation error"
		try:
			output = c.stderr.read().decode('utf-8')
			output = re.sub(r'[^\x00-\x7F]+',' ',output)
			output = re.escape(output)
		except Exception as e:
			print(str(e))
			pass

		if(os.path.isfile("Cell/Program")==False):
			return output
		else:
			return 0
	except:
		return "Compilation error"

# This function is used to compile the Java file
# This function is specific to C++
def compileJava():
	try:
		file = "Main.java"
		os.chdir("Cell/")
		c = subprocess.Popen(["javac","Main.java"],stdout=subprocess.PIPE,stderr=subprocess.PIPE)

		output = "Compilation error"
		try:
			output = c.stderr.read().decode('utf-8')
			output = re.sub(r'[^\x00-\x7F]+',' ',output)
			output = re.escape(output)
		except Exception as e:
			print(str(e))
			pass

		os.chdir("../")
		if(os.path.isfile("Cell/Main.class")==False):
			return output
		else:
			return 0
	except:
		return "Compilation error"


# This function is used to get the list of input and corresponding output files. 
# This function is common for all languages.

def getIOReady(problemcode):
	try:
		input_files = []
		output_files = []
		l = len(os.listdir("Problems/"+problemcode+"/input/"))
		for k in range(l):
			input_files.append("Problems/"+problemcode+"/input/"+str(k+1)+".in")
			output_files.append("Problems/"+problemcode+"/output/"+str(k+1)+".out")

		return input_files,output_files
	except:
		return [-1],[-1]
	return [0],[0]

# This function is used to get the time limit of the problem.
# This function is common for all languages.

def fetchTimeLimit(cursor,problemcode):
	try:
		cursor.execute("select time from problems where code='"+problemcode+"'")
		time_limit = (cursor.fetchall())[0][0]
		return time_limit
	except:
		return -1


# This function is used to run and check the output of the C++ program.
# This function is specific to C++.

def runCPPProgram(input_files,output_files,time_limit):

	status = 5
	error = ""

	for i in range(len(input_files)):
		fin = open(input_files[i])
		
		os.seteuid(ojid)

		p = subprocess.Popen("Cell/Program",stdin=fin,stdout=subprocess.PIPE)

		os.seteuid(rootid)

		print(os.geteuid())
		time.sleep(time_limit)

		if(p.poll() is None):
			p.kill()
			status = 2
			error = "Time limit exceeded on Test case "+str(i+1)
			return status,error

		if(p.returncode != 0):
			status = 4
			error = "Non-zero exit code on Test case "+str(i+1)
			return status,error

		user_output = ""
		try:
			user_output = p.communicate()[0].decode('ascii')
		except:
			status = 3
			error = "Wrong answer on Test case "+str(i+1)
			os.chdir("../")
			return status,error

		fin.close()

		fout = open(output_files[i])
		expected_output = fout.read()

		if(user_output!=expected_output):
			status = 3
			error = "Wrong answer on Test case "+str(i+1)
			return status,error

		fout.close()

	return status,error


# This function is used to run and check the output of the Java program.
# This function is specific to Java.

def runJavaProgram(input_files,output_files,time_limit):

	status = 5
	error = ""

	os.chdir("Cell/")
	for i in range(len(input_files)):
		fin = open("../"+input_files[i])

		os.seteuid(ojid)

		p = subprocess.Popen(["java","Main"],stdin=fin,stdout=subprocess.PIPE)

		os.seteuid(rootid)
		
		# Time limit for java is little more
		
		time.sleep(2 + 10*time_limit)

		if(p.poll() is None):
			p.kill()
			status = 2
			error = "Time limit exceeded on Test case "+str(i+1)
			os.chdir("../")
			return status,error

		if(p.returncode != 0):
			status = 4
			error = "Non-zero exit code on Test case "+str(i+1)
			os.chdir("../")
			return status,error

		user_output = ""
		try:
			user_output = p.communicate()[0].decode('ascii')
		except:
			status = 3
			error = "Wrong answer on Test case "+str(i+1)
			os.chdir("../")
			return status,error

		fin.close()

		fout = open("../"+output_files[i])
		expected_output = fout.read()

		if(user_output!=expected_output):
			status = 3
			error = "Wrong answer on Test case "+str(i+1)
			os.chdir("../")
			return status,error

		fout.close()

	os.chdir("../")
	return status,error


# This function is used to update the leaderboard based on result of the submission.
# This function is common for all languages.

def updateScoreboard(cursor,problemcode,username):

	cursor.execute("select * from submissions where status=5 and username='"+username+"' and problemcode='"+problemcode+"'")

	res = cursor.fetchall()

	if(len(res)==0):
		cursor.execute("update problems set users_solved=users_solved+1 where code='"+problemcode+"'")
		cursor.execute("select * from leaderboard where username='"+username+"'")
		res = cursor.fetchall()
		if(len(res)==0):
			try:
				cursor.execute("insert into leaderboard(username,score) values ('"+username+"',100)")
				db.commit()
			except:
				print("Error in committing to database..")
				exit(-1)
		else:
			try:
				cursor.execute("update leaderboard set score=score+100 where username='"+username+"'")
				db.commit()
			except:
				print("Error in committing to database..")
				exit(-1)

# This function is used to remove folder Cell
# This function is common for all languages.

def losePermissions():
	try:
		os.system("rm -r Cell/")
		return 0
	except:
		return -1

while(True):
	
	#Judge until stopped
	
	if(judgeOnce==False):
		mySocket.listen(1)
		print("Listening..")
		conn, addr = mySocket.accept()
		print("Submission received..")
		conn.close()
	else:
		judgeOnce = False

	db = pymysql.connect(dbserver,username,password,database)
	cursor = db.cursor()
	cursor.execute("select * from submissions where status=0")
	for row in cursor.fetchall():
		if(row[3]==0):
			
			#If the submission is in C++
			
			if(gainPermissions()==-1):
				print("Error occured in getting folder permissions..")
				exit(-1)

			if(fetchCPPCode(row[6])==-1):
				print("Error occured in file creation..")
				exit(-1)

			compilationResult = compileCPP()	

			if(compilationResult!=0):
				try:
					cursor.execute("update submissions set status=1,error='"+str(compilationResult)+"' where id="+str(row[0]))
					db.commit()
					if(losePermissions()==-1):
						print("Error occured in getting folder permissions..")
						exit(-1)
					continue
				except:
					print()
					print("Error occured in committing to database..")
					exit(-1)

			time_limit = fetchTimeLimit(cursor,row[2])

			if(time_limit==-1):
				print("Error fetching the time limit..")
				exit(-1)
			

			input_files,output_files = getIOReady(row[2])

			if(len(input_files)==0 or input_files[0]==-1):
				print("Error in fetching I/O files..")
				exit(-1)
			
			status,error = runCPPProgram(input_files,output_files,time_limit)

			if(status==5):
				updateScoreboard(cursor,row[2],row[1])

			try:
				cursor.execute("update submissions set status="+str(status)+",error='"+error+"' where id="+str(row[0]))
				db.commit()
			except:
				print("Error in committing to database..")
				exit(-1)

			if(losePermissions()==-1):
				print("Error occured in losing folder permissions..")
				exit(-1)

		else:
			#If the submission is Java. See how similar the steps of C++ and Java is. You can similarly add your own compilers/languages.
			if(gainPermissions()==-1):
				print("Error occured in getting folder permissions..")
				exit(-1)

			if(fetchJavaCode(row[6])==-1):
				print("Error occured in file creation..")
				exit(-1)

			compilationResult = compileJava()
			if(compilationResult!=0):
				try:
					cursor.execute("update submissions set status=1,error='"+str(compilationResult)+"' where id="+str(row[0]))
					db.commit()
					if(losePermissions()==-1):
						print("Error occured in getting folder permissions..")
						exit(-1)
					continue
				except:
					print("Error occured in committing to database..")
					exit(-1)


			time_limit = fetchTimeLimit(cursor,row[2])

			if(time_limit==-1):
				print("Error fetching the time limit..")
				exit(-1)
			

			input_files,output_files = getIOReady(row[2])

			if(len(input_files)==0 or input_files[0]==-1):
				print("Error in fetching I/O files..")
				exit(-1)

			status,error = runJavaProgram(input_files,output_files,time_limit)

			if(status==5):
				updateScoreboard(cursor,row[2],row[1])

			try:
				cursor.execute("update submissions set status="+str(status)+",error='"+error+"' where id="+str(row[0]))
				db.commit()
			except:
				print("Error in committing to database..")
				exit(-1)

			if(losePermissions()==-1):
				print("Error occured in getting folder permissions..")
				exit(-1)
	db.close()
