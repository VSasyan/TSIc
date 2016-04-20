#Install Jenkins

This is the Debian package repository of Jenkins to automate installation and upgrade. To use this repository, first add the key to your system:

    wget -q -O - http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | sudo apt-key add -

Then add the following entry in your /etc/apt/sources.list:

    deb http://pkg.jenkins-ci.org/debian binary/

Update your local package index, then finally install Jenkins:

    sudo apt-get update
    sudo apt-get install jenkins


Once done, open your browser an go to : http://localhost:8080 and see Jenkins' interface.  
By default, Jenkins is running on the port 8080, but you are free to change it in the configuration file `/etc/default/jenkins`.

#Configure Jenkins

See : 

https://www.cloudbees.com/blog/better-integration-between-jenkins-and-github-github-jenkins-plugin  

Jenkins server could not run locally, because we schould secifie the server's host in the Git hub web hook of the repository, and we could not use `localhost` instead.


http://www.sitepoint.com/continuous-integration-with-jenkins-2/
 
