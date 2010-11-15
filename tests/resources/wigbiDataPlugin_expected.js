function WigbiDataPluginJavaScriptGeneratorTestClass()
{	
	/* Private variables *****/

	this._name = "foo";
	this._age = 20;
	this._date = "";
	this._dateTime = "";
	this._time = "";
	this._timeStamp = "";
	this._noValue = "";
	this._noType = "foo";


	/* Initialize ************/
	
	$.extend(this, new WigbiDataPlugin());


	/* Properties ************/
	
	// Get/set the value of the _name variable
	this.name = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._name = newVal;
		return this._name;
	};
	
	// Get/set the value of the _age variable
	this.age = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._age = newVal;
		return this._age;
	};
	
	// Get/set the value of the _date variable
	this.date = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._date = newVal;
		return this._date;
	};
	
	// Get/set the value of the _dateTime variable
	this.dateTime = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._dateTime = newVal;
		return this._dateTime;
	};
	
	// Get/set the value of the _time variable
	this.time = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._time = newVal;
		return this._time;
	};
	
	// Get/set the value of the _timeStamp variable
	this.timeStamp = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._timeStamp = newVal;
		return this._timeStamp;
	};
	
	// Get/set the value of the _noValue variable
	this.noValue = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._noValue = newVal;
		return this._noValue;
	};
	
	// Get/set the value of the _noType variable
	this.noType = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._noType = newVal;
		return this._noType;
	};
	
	
	/* Non-static AJAX functions *********/
	
	// Perform an asynchronous nonStaticFunc function
	this.nonStaticFunc = function(foo, bar, onNonStaticFunc) { Wigbi.ajax("WigbiDataPluginJavaScriptGeneratorTestClass", this, "nonStaticFunc", [foo, bar], onNonStaticFunc); };
};


/* Static AJAX functions *********/ 

// Perform an asynchronous staticFunc function
WigbiDataPluginJavaScriptGeneratorTestClass.staticFunc = function(bar, foo, onStaticFunc) { Wigbi.ajax("WigbiDataPluginJavaScriptGeneratorTestClass", null, "staticFunc", [bar, foo], onStaticFunc); };

