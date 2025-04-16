<!-- resources/views/alumni/joblisting/index.blade.php -->
<section class="mb-4">
    <h3 class="mb-3">Job Listings</h3>
    @if(isset($jobListings['error']))
        <div class="alert alert-danger">
            <p>Error: {{ $jobListings['error'] }}</p>
        </div>
    @else
        @if(count($jobListings['data']) > 0)
            <div class="list-group">
                @foreach($jobListings['data'] as $job)
                    <a href="{{ $job['url'] }}" class="list-group-item list-group-item-action mb-2" target="_blank">
                        <h5 class="mb-1">{{ $job['title'] }}</h5>
                        <p class="mb-1">{{ $job['company_name'] }}</p>
                        <small>{{ $job['location'] }}</small>
                    </a>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                <p>No job listings available at the moment. Check back later!</p>
            </div>
        @endif
    @endif
</section>
