<div wire:ignore
	x-data
	x-init="() => {
	var choices = new Choices($refs.{{ $attributes['prettyname'] }}, {
		maxItemCount: 3,
            renderSelectedChoices: 'auto',
            loadingText: 'Loading...',
            noResultsText: 'No results found.',
            noChoicesText: 'No choices to choose from.',
			itemSelectText: 'Press to select.',
			placeholder: true,
			placeholderValue: 'Begin typing to search for categories.',
            maxItemText: (maxItemCount) => {
            return `Only ${maxItemCount} values can be added`;
            },
            valueComparer: (value1, value2) => {
            return value1 === value2;
            },
            classNames: {
            containerOuter: 'choices',
            containerInner: 'choices__inner',
            input: 'choices__input',
            inputCloned: 'choices__input--cloned',
            list: 'choices__list',
            listItems: 'choices__list--multiple',
            listSingle: 'choices__list--single',
            listDropdown: 'choices__list--dropdown',
            item: 'choices__item',
            itemSelectable: 'choices__item--selectable',
            itemDisabled: 'choices__item--disabled',
            itemChoice: 'choices__item--choice',
            placeholder: 'choices__placeholder',
            group: 'choices__group',
            groupHeading: 'choices__heading',
            button: 'choices__button',
            activeState: 'is-active',
            focusState: 'is-focused',
            openState: 'is-open',
            disabledState: 'is-disabled',
            highlightedState: 'is-highlighted',
            selectedState: 'is-selected',
            flippedState: 'is-flipped',
            loadingState: 'is-loading',
            noResults: 'has-no-results',
            noChoices: 'has-no-choices'
            },
	});
	choices.passedElement.element.addEventListener(
	  'change',
	  function(event) {
	  		values = getSelectValues($refs.{{ $attributes['prettyname'] }});
		    @this.set('{{ $attributes['wire:model'] }}', values);
	  },
	  false,
	);
	items = {!! $attributes['selected'] !!};
	if(Array.isArray(items)){
		items.forEach(function(select) {
			choices.setChoiceByValue((select).toString());
		});
	}
	}
	function getSelectValues(select) {
	  var result = [];
	  var options = select && select.options;
	  var opt;
	  for (var i=0, iLen=options.length; i<iLen; i++) {
	    opt = options[i];
	    if (opt.selected) {
	      result.push(opt.value || opt.text);
	    }
	  }
	  return result;
	}
	">
    <select id="{{ $attributes['prettyname'] }}" wire-model="{{ $attributes['wire:model'] }}" wire:change="{{ $attributes['wire:change'] }}" x-ref="{{ $attributes['prettyname'] }}" class="p-0" multiple="multiple">
    	@if(count($attributes['options'])>0)
			@foreach($attributes['options'] as $key=>$option)
				<option value="">Please provide between one and three categories.</option>
	    		<option value="{{$option}}" >{{$option}}</option>
	    	@endforeach
    	@endif
	</select>
</div>