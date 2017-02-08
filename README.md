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


###Getting started

In order to set application up you must follow by steps:

1. Install VirtualBox, Vagrant,
2. Install the following vagrant plugins
    - Vagrant WinNFSd: `vagrant plugin install vagrant-winnfsd`
3. Go to vagrant directory: `cd vagrant`
4. Run Vagrant Virtual Machine `vagrant up`
