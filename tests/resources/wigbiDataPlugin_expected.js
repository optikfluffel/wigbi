function WigbiDataPluginJavaScriptGeneratorTestClass()
{	
	this._name = "foo";
	this._age = 20;
	this._date = "";
	this._dateTime = "";
	this._time = "";
	this._timeStamp = "";
	this._noValue = "";
	this._noType = "foo";


	$.extend(this, new WigbiDataPlugin());


	this.name = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._name = newVal;
		return this._name;
	};
	
	this.age = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._age = newVal;
		return this._age;
	};
	
	this.date = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._date = newVal;
		return this._date;
	};
	
	this.dateTime = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._dateTime = newVal;
		return this._dateTime;
	};
	
	this.time = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._time = newVal;
		return this._time;
	};
	
	this.timeStamp = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._timeStamp = newVal;
		return this._timeStamp;
	};
	
	this.noValue = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._noValue = newVal;
		return this._noValue;
	};
	
	this.noType = function(newVal)
	{
		if (typeof(newVal) != 'undefined') 
			this._noType = newVal;
		return this._noType;
	};
	
	
	this.nonStaticFunc = function(foo, bar, onNonStaticFunc) { Wigbi.ajax("WigbiDataPluginJavaScriptGeneratorTestClass", this, "nonStaticFunc", [foo, bar], onNonStaticFunc); };
};


WigbiDataPluginJavaScriptGeneratorTestClass.staticFunc = function(bar, foo, onStaticFunc) { Wigbi.ajax("WigbiDataPluginJavaScriptGeneratorTestClass", null, "staticFunc", [bar, foo], onStaticFunc); };

