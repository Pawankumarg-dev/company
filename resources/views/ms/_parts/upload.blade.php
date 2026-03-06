<td>
     <?php $qpset = 'question_paper_'.$set; ?>
    

        @if(!is_null($qp) && !is_null($qp->pivot->$qpset))
            <span class="btn btn-xs btn-success">
                Uploaded
            </span>
        @else
            <span class="btn btn-xs btn-danger">
                Not Uploaded
            </span>
        @endif
    </a>
    
</form>
</td>

