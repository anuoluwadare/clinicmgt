<!--
function popUpWindow(url,windowName,windowSettings) {
	var newWin
	newWin=window.open(url,windowName,windowSettings)
	newWin.focus()
}

function submitForm(formObj,Action)
{	
	formObj.action=Action
	formObj.submit() 
}

function ValidateEntry(inputObj,sMsg){
	if(inputObj.value==""){
		alert(sMsg)
		inputObj.focus()
		return(false)
	}
	
	return(true)
}

function displayLOV(text_list,destObj,sDefaultValue){
	/*display in a drop-down, a list of values (LOV) 
	related to a given value.
	e.g all LGA in a state*/
	
	arrList=text_list.split(";")

	//clear the dest drop down object
	destObj.length=0

	for(i=1;i<arrList.length;i++){
		optionObj=document.createElement("option")
		

		arrValue_Text_Pair=arrList[i].split(":")
		sValue=arrValue_Text_Pair[0]
		sText=arrValue_Text_Pair[0]
		if(arrValue_Text_Pair.length>1){sText=arrValue_Text_Pair[1]}

		
		optionObj.value=sValue
		optionObj.text=sText
		if(sValue==sDefaultValue){optionObj.selected=true}
		destObj.add(optionObj)
		
	}
}

function toggleCheck(elementName,thisObj){
	this_elements=thisObj.form.elements[elementName]
	
	if(typeof(this_elements)== 'undefined') return
	
	if(this_elements.length){
		for(i=0; i<this_elements.length; i++){
			this_elements[i].checked=thisObj.checked
		}
	}
	else this_elements.checked=thisObj.checked
}

function setCheckboxes(formName,elementName,checkStatus){
	formObj=eval(formName)
	this_elements=formObj.elements[elementName]
	
	if(typeof(this_elements)== 'undefined') return
	
	if(this_elements.length){
		for(i=0; i<this_elements.length; i++){
			this_elements[i].checked=checkStatus
		}
	}
	else this_elements.checked=checkStatus
}

//-->
