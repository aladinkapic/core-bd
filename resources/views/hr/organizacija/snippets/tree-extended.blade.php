<ul>
    @foreach($childs as $child)
        <li>
            <span class="tf-nc custom-tf-nc">
                <span class="tree-element tree-element-sm">
                    {{ $child->naziv ?? 'Nema imena' }}
                </span>
            </span>

            @if(count($child->radnaMjesta))
                <ul>
                    @foreach($child->radnaMjesta as $rm)
                        <li>
                            <span class="tf-nc custom-tf-nc">
                                <span class="tree-element tree-element-sm">
                                    {{ $rm->naziv_rm ?? 'Nema imena' }}
                                </span>
                            </span>

                            @if(count($rm->sluzbenici))
                                <ul>
                                    @foreach($rm->sluzbenici as $sl)
                                        <li>
                                            <span class="tf-nc custom-tf-nc">
                                                <span class="tree-element tree-element-sm">
                                                    {{ $sl->ime_prezime ?? 'Nema imena' }}
                                                </span>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </li>
                    @endforeach
                </ul>
            @endif

            @if(count($child->childs))
                @include('hr.organizacija.snippets.tree-extended',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>