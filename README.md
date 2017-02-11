###Deploys happen automatically
Every push to develop will deploy a new version of this app.

STAGING: [https://training-tasks.herokuapp.com](https://training-tasks.herokuapp.com)

###Tests happen automatically
Every create PR or push some changes will run tests:
 - PHP CodeSniffer
 - PHP Loc
 - PHP Mess Detector
 - PHP Depend
 - PHP Copy/Paste Detector 

JENKINS: [http://jenkins.ttarnawski.usermd.net/job/TaskManagerTestPR](http://jenkins.ttarnawski.usermd.net/job/TaskManagerTestPR)


###Getting started with Vagrant

In order to set application up you must follow by steps:

1.Install VirtualBox and Vagrant
2.Install Vagrant WinNFSd plugin for Windows users
```
vagrant plugin install vagrant-winnfsd
```
3.Go to vagrant directory and run Vagrant Virtual Machine:
```
cd vagrant
vagrant up
```
4.After that you need to add this line into /etc/hosts:
```
10.0.0.200  task-manager.dev www.task-manager.dev
```

###Getting started with Docker
```
docker-compose up
```

###PHPSpec test:
```
bin/phpspec run
```