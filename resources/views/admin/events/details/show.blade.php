<x-layout title="Event Details">
    <div class="container-fluid px-4">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Event</a></li>
            <li class="breadcrumb-item active">Event Details</li>
        </ol>
    </div>

    <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample">
        <!--Event Details -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapseOne">
                    <i class="fas fa-table me-1"></i>
                    <span>Event Details</span>
                </button>
            </h2>
            <x-accordion-event-details.index :$event />
        </div>
        <!--Judges -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                    aria-controls="panelsStayOpen-collapseTwo">
                    <i class="fas fa-users me-1"></i>
                    Judges
                </button>
            </h2>
            <x-accordion-judge.index :$event />
        </div>
        <!--Candidates -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                    aria-controls="panelsStayOpen-collapseThree">
                    <i class="fas fa-user me-1"></i>
                    <span>Candidates</span>
                </button>
            </h2>
            <x-accordion-candidate.index :$event />
        </div>
        <!--Segments -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                    aria-controls="panelsStayOpen-collapseFour">
                    <i class="fas fa-trophy me-1"></i>
                    <span>Segments</span>
                </button>
            </h2>
            <x-accordion-segment.index :$event />
        </div>
        <!--Finalist -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false"
                    aria-controls="panelsStayOpen-collapseFive">
                    <i class="fas fa-star me-1"></i>
                    <span>Finalist</span>
                </button>
            </h2>
            <x-accordion-finalist.index :$event/>
        </div>
    </div>
    <!-- MESSAGE NOTIFICATION -->
    <x-flash-message />
    <x-error-flash-message />
    <x-scripts.index :$event />
    <script>
        let toggleCollapses = sessionStorage.getItem("toggledCollapses") && sessionStorage.getItem("toggledCollapses") !==
            undefined ?
            JSON.parse(sessionStorage.getItem("toggledCollapses")) : [];

        window.addEventListener("load", (event) => {
            for (let i = 0; i < toggleCollapses.length; i++) {
                let id = `#${toggleCollapses[i]}`;
                console.log(id);

                new bootstrap.Collapse(id, {
                    toggle: true
                })
            }
            // if(toggleCollapses.length == 0) {
            //     new bootstrap.Collapse('#panelsStayOpen-collapseOne', {
            //         toggle: true
            //     })
            // }

            /* TODO: Scroll to the first enabled collapse */
            // var scrollDiv = document.getElementById("panelsStayOpen-collapseThree").closest(".accordion-item").offsetTop - 70;
            // window.scrollTo({ top: scrollDiv, behavior: 'smooth'});

        });

        const myCollapsible = document.getElementById('accordionPanelsStayOpenExample')
        myCollapsible.addEventListener('shown.bs.collapse', event => {
            if (toggleCollapses.includes(event.target.id)) return;

            toggleCollapses.push(event.target.id);
            sessionStorage.setItem("toggledCollapses", JSON.stringify(toggleCollapses));
            console.log(toggleCollapses);
            console.log('sesh', sessionStorage.getItem("toggledCollapses"));

        })
        myCollapsible.addEventListener('hidden.bs.collapse', event => {
            if (!toggleCollapses.includes(event.target.id)) return;

            toggleCollapses = toggleCollapses.filter(item => item !== event.target.id)
            sessionStorage.setItem("toggledCollapses", JSON.stringify(toggleCollapses));
        })
    </script>
</x-layout>
