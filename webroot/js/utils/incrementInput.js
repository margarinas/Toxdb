function incrementInput(input, num) {
	optArray = new Array('id','name','for','href');
	for(i=0; i<optArray.length; i++) {
		if(input.attr(optArray[i])) {
			strArray = input.attr(optArray[i]).split('0');
			input.attr(optArray[i],strArray[0]+num+strArray.pop());
				//console.log(strArray.shift()+num+strArray);
			}

		}
		if(input.is('a')) {
			input.text(input.text().slice(0,-1)+(num+1));
		}
		if(input.is('select'))
			input.find('option:selected').prop("selected", false);
		//console.log(input.html());

		return input;
}