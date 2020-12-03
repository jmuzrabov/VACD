	$("#telNumber").click(function(){
			console.log($('.card-footer'));
			let option = document.createElement('option');
			option.setAttribute('value','');
			let num = 0123456;
			option.append(num);
			let select = document.createElement('select');
			select.setAttribute('id','cars');
			select.append(option);
			let label = document.createElement('label');
			label.setAttribute('for','cars');
			label.append('Test');
			let container = $('.card-footer');
			let innerContainer = document.createElement('div');
			innerContainer.setAttribute('class','col-md-4');
			innerContainer.append(label);
			innerContainer.append(select);
			container.append(innerContainer);


		});


		let ul = $('#zettel');
		let li = document.createElement('li');
		let spanNr = document.createElement('span');
		let spanName = document.createElement('span');
		let spanIcon = document.createElement('span');
		let input = document.createElement('input');
		let label = document.createElement('label');


		label.setAttribute('class','delet');
		label.setAttribute('for','delet');

		input.setAttribute('class','del-item');
		// input.setAttribute('id','delet');
		input.setAttribute('type','submit');
		input.setAttribute('style','display:none');

		spanNr.append(telnr);
		spanName.append(graphname);
		spanIcon.append(label);
		spanIcon.append(input);

		li.setAttribute('class','mb-3');
		li.setAttribute('id',graphid);

		li.append(spanNr);
		li.append(spanName);
		li.append(spanIcon);

		ul.append(li);


		jzp527e

		5y0i9ml

		z1wbv0n

		nkn240t

		m9ahgg6