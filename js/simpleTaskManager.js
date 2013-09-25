/**
 * Class: SimpleTaskManager
 * provides an interface to manage and run asynchronous tasks.
 * 
 */
function SimpleTaskManager() {
	this.taskQueue = [];
	this.prevTaskHandle = 0;
	this.taskRunning = false;
	this.runningTask = null;
}

/**
 * Function: enqueueAsyncTask
 * Put an asynchronous task into the queue.
 * Asynchronous means the given function returns immediately
 * upon execution but e.g. spawns another thread.
 * After the task finished executing it must call
 * asyncTaskFinished to indicate this.
 * 
 * Parameters:
 * taskFunction - reference to the task function
 *                This function is executed in order to run the task.
 *                The task handle is adopted as the only
 *                parameter on execution
 *                Prototype: function taskFunction(taskHandle);
 * startCbk     - (optional) Callback function to be executed, before
 *                taskFunction is being started.
 *                Adopts task handle as first parameter
 * finishCbk    - (optional) Callback function to be executed, after
 *                task finished executing (i.e. asyncTaskFinished called)
 *                Adopts task handle as first parameter
 *                
 * Return:
 * task handle
 */
SimpleTaskManager.prototype.enqueueAsyncTask =
		function(taskFunction, startCbk, finishCbk) {
	startCbk = startCbk || null;
	finishCbk = finishCbk || null;
	var task = new SimpleTaskManagerTask();
	task.handle = this.generateTaskHandle();
	task.sync = false;
	task.taskFunction = taskFunction;
	task.startCbk = startCbk;
	task.finishCbk = finishCbk;
	
	this.taskQueue.push(task);
	this.schedulerMain();
	
	return task.handle;
};

/**
 * Function: asyncTaskFinished
 * This function has to be called by asynchronous tasks when they
 * finish executing.
 * 
 * Parameters:
 * taskHandle - Handle of the finishing task
 */
SimpleTaskManager.prototype.asyncTaskFinished = function(taskHandle) {
	if(taskHandle != this.runningTask.handle) {
		throw new Error("Finishing task handle unknown.");
	}
	if(this.runningTask.finishCbk) {
		this.runningTask.finishCbk(this.runningTask.handle);
	}
	this.taskRunning = false;
	this.runningTask = null;
	this.schedulerMain();
};

SimpleTaskManager.prototype.taskPush = function(task) {
	this.taskQueue.push(task);
};

SimpleTaskManager.prototype.taskPop = function() {
	return this.taskQueue.shift();
};

SimpleTaskManager.prototype.generateTaskHandle = function() {
	this.prevTaskHandle++;
	return this.prevTaskHandle;
};


SimpleTaskManager.prototype.schedulerMain = function() {
	if (this.taskRunning == true) {
		return;
	}
	this.runNextTask();
};

SimpleTaskManager.prototype.runNextTask = function() {
	if (this.taskQueue.length < 1) {
		return;
	}
	this.taskRunning = true;
	var crntTask = this.taskPop();
	this.runningTask = crntTask;
	if(crntTask.startCbk) {
		crntTask.startCbk(crntTask.handle);
	}
	crntTask.taskFunction(crntTask.handle);
};

function SimpleTaskManagerTask() {
	this.handle = null; // task handle
	this.taskFunction = null; // function to run the task
	this.sync = false; // synchronous taskFunction 
	this.startCbk = null; // callback to be executed before task starts
	this.finishCbk = null; // callback to be executed after task finished
}
