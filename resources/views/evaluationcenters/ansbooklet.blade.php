<style>
    @page { margin: 0px; }
    body { margin: 0px; }
</style>
@for($i=2;$i<$answerbooklet->pages + 1;$i++)
    <img src="/var/www/html/rcinber/public/files/answerbooklets/26/{{ $application->candidate_id }}_{{ $application->subject_id }}_{{$application->id}}_{{$i}}.png" style="width:100%;">
@endfor

