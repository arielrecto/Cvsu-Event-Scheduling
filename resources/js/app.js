import axios from "axios";
import "./bootstrap";

import Alpine from "alpinejs";

import defaultEvaluationData from "./json-data/evaluation-form.json";
import speakerDefaultEvaluationFormData from "./json-data/speaker-form.json";

window.Alpine = Alpine;

Alpine.data("calendar", (data) => ({
    events: data,
    init() {
        const calendarElement = this.$refs.calendar;

        console.log(this.events);

        const calendar = new FullCalendar.Calendar(calendarElement, {
            initialView: "dayGridMonth",
            events: this.events.map((event) => ({
                title: event.name,
                start: event.start_date + "T" + event.start_time,
                end: event.end_date + "T" + event.end_time,
                url: `/events/${event.id}`,
                color: event.color || "#12372A",
            })),
        });

        calendar.render();
    },
}));

Alpine.data("mapRender", () => ({
    locations: {
        lat: null,
        lng: null,
        address: null,
    },
    init() {
        const mapElement = this.$refs.map;

        const map = L.map(mapElement).setView([14.4128588, 120.97982], 16);

        // let searchControl = L.esri.Geocoding.geosearch().addTo(map);

        // var results = L.layerGroup().addTo(map);

       L.Control.geocoder().on('markgeocode', (event) => {
            this.locations = {
                lat : event.geocode.properties.lat,
                lng : event.geocode.properties.lon,
                address : event.geocode.name
            }
        }).addTo(map);


        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution:
                '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        }).addTo(map);

        // searchControl.on("results", function (data) {
        //     console.log('====================================');
        //     console.log(data);
        //     console.log('====================================');
        //     results.clearLayers();
        //     for (var i = data.results.length - 1; i >= 0; i--) {
        //         results.addLayer(L.marker(data.results[i].latlng));
        //     }
        // });

        let pinMarker = null;

        const mapClick = (e) => {
            if (pinMarker !== null) {
                map.removeLayer(pinMarker);

                this.locations = {
                    lat: null,
                    lng: null,
                    address: null,
                };

                pinMarker = null;

                return;
            }

            const coordinates = e.latlng;

            const marker = L.marker([coordinates.lat, coordinates.lng]).addTo(
                map
            );

            pinMarker = marker;

            this.getAddress(coordinates.lat, coordinates.lng);

            this.locations = {
                ...this.locations,
                lat: coordinates.lat,
                lng: coordinates.lng,
            };

            console.log(this.locations);
        };

        map.on("click", mapClick);
    },

    async getAddress(lat, lng) {
        try {
            const response = await axios.get(
                `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`
            );

            this.locations.address = response.data.display_name;

            console.log(response.data);
        } catch (error) {
            console.log(error);
        }
    },
}));

Alpine.data("mapDisplay", (data) => ({
    location: data,
    address: data.address,
    init() {
        const mapElement = this.$refs.map;

        const map = L.map(mapElement).setView(
            [this.location.lat, this.location.lng],
            16
        );

        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution:
                '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        }).addTo(map);

        const marker = L.marker([this.location.lat, this.location.lng]).addTo(
            map
        );

        console.log("init", this.location);
    },
}));

Alpine.data("textEditor", () => ({
    descriptions: null,
    quillInstance: null,
    init() {
        const editor = this.$refs.editor;

        console.log("Hello world");

        this.quillInstance = new Quill(editor, {
            theme: "snow",
        });
    },

    getContent() {
        const content = this.quillInstance.root.innerHTML;

        this.descriptions = content;

        console.log(this.descriptions);
    },
}));

Alpine.data("imageUploadHandler", () => ({
    image: null,
    uploadHandler(e) {
        const { files } = e.target;

        const reader = new FileReader();

        reader.onload = function () {
            this.image = reader.result;
        }.bind(this);

        reader.readAsDataURL(files[0]);
    },
}));

Alpine.data("evaluationFormGenerator", () => ({
    form: {
        title: null,
        fields: [],
        speakers: [],
    },
    fieldBlueprint: {
        localId: 1,
        question: null,
        input_type: "",
        data: null,
    },
    titleToggle: true,
    fieldToggle: false,
    editFieldId: null,
    addSpeakerField : null,
    init() {
        defaultEvaluationData.default.forEach((item) => {
            this.form.fields.push({
                ...this.fieldBlueprint,
                ...item,
            });
            this.fieldBlueprint.localId += 1;
        });

        console.log("====================================");
        console.log(this.form);
        console.log("====================================");
    },
    addField() {
        console.log(this.fieldBlueprint);

        this.fieldBlueprint = {
            ...this.fieldBlueprint,
            localId: this.fieldBlueprint.localId + 1,
        };

        (this.form = {
            ...this.form,
            fields: [...this.form.fields, this.fieldBlueprint],
        }),
            (this.fieldBlueprint = {
                ...this.fieldBlueprint,
                question: null,
                input_type: "",
                data: null,
            });

        console.log(this.fieldBlueprint, "new blue print");
    },
    checkInputTypeField(e) {
        const type = e.target.value;

        if (type !== "radio") {
            console.log("not radio");

            this.fieldBlueprint = {
                localId: this.fieldBlueprint.localId,
                question: null,
                input_type: "",
                data: null,
            };
            return;
        }

        this.fieldBlueprint = {
            ...this.fieldBlueprint,
            radio_max: 1,
        };
    },
    removeField(localId, speakerIndex = null) {

        if(!speakerIndex){

            console.log('====================================');
            console.log(speakerIndex, localId);
            console.log('====================================');

            this.form.speakers[0] = {
                ...this.form.speakers[0],
                fields : [...this.form.speakers[0].fields.filter((item) => item.localId !== localId)]
            }
            return;
        }

        this.form = {
            ...this.form,
            fields: this.form.fields.filter(
                (field) => field.localId !== localId
            ),
        };
    },
    addSpeakersDefault(speakers) {
        console.log("====================================");
        console.log(speakers);
        console.log("====================================");
        speakers.forEach((item) => {
            const data = {
                name: `${item.speaker.last_name}, ${item.speaker.first_name}, ${
                    item.speaker.middle_name === null
                        ? ""
                        : item.speaker.middle_name
                }`,
                fields: [],
            };

            speakerDefaultEvaluationFormData.default.map((field) => {
                data.fields.push({
                    ...field,
                    localId: (this.fieldBlueprint.localId += 1),
                });
            });

            this.form.speakers.push(data);
        });

        console.log("====================================");
        console.log(this.form);
        console.log("====================================");
    },
}));

Alpine.data("displayClock", () => ({
    time: null,
    init() {
        setInterval(() => {
            const clock = this.$refs.MyClockDisplay;
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";

            if (h == 0) {
                h = 12;
            }

            if (h > 12) {
                h = h - 12;
                session = "PM";
            }

            h = h < 10 ? "0" + h : h;
            m = m < 10 ? "0" + m : m;
            s = s < 10 ? "0" + s : s;

            this.time = h + ":" + m + ":" + s + " " + session;

            clock.innerText = this.time;
            clock.textContent = this.time;
        }, 1000);
    },
}));

Alpine.data("pieChart", (data) => ({
    init() {
        const labels = [];
        const series = [];

        data.map((item) => {
            const key = Object.keys(item);
            const value = Object.values(item);
            labels.push(key);
            series.push(value);
        });

        console.log(labels, series);

        const chartElement = this.$refs.chart;

        const options = {
            series: [...series],
            chart: {
                width: 380,
                type: "pie",
            },
            labels: [...labels],
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200,
                        },
                        legend: {
                            position: "bottom",
                        },
                    },
                },
            ],
        };

        var chart = new ApexCharts(chartElement, options);
        chart.render();
    },
}));

Alpine.data("print", () => ({
    printComponent() {
        const element = this.$refs.print;
        const header = this.$refs.header;
        const main = this.$refs.main;
        const reportHeader = this.$refs.reportHeader;

        header.classList.add("hidden");
        main.classList.add("w-full");
        main.classList.remove("w-4/6");
        reportHeader.classList.remove("hidden");
        reportHeader.classList.add("flex");

        window.print();

        header.classList.remove("hidden");
        main.classList.add("w-4/6");
        main.classList.remove("w-full");
        reportHeader.classList.remove("flex");
        reportHeader.classList.add("hidden");
    },
}));

Alpine.data("getSections", (data) => ({
    sections: [],
    course: null,
    init() {
        this.$watch("course", () => {
            this.getSectionsData();
        });
    },
    async getSectionsData() {
        try {
            const { data } = await axios.get(`/section/course/${this.course}`);

            this.sections = [...data.sections];
        } catch (error) {
            console.log("====================================");
            console.log(error);
            console.log("====================================");
        }
    },
}));

Alpine.data("getEventAttendances", (id) => ({
    section: null,
    course: null,
    search: "",
    category: null,
    attendances: [],
    eventId: id,
    changeInpuTypeToggle: false,
    init() {
        this.getInitAttendances();
    },
    async getInitAttendances() {
        try {
            let url = `/faculty/events/${this.eventId}/attendances`;

            if (this.category) {
                url = `/faculty/events/${this.eventId}/attendances?category=${this.category}&search=${this.search}`;
            }

            console.log('====================================');
            console.log(this.search);
            console.log('====================================');

            const { data } = await axios.get(url);

            console.log(data);

            this.attendances = [...data.attendances];

            setTimeout(() => {
                this.getInitAttendances();
            }, 2000);
        } catch (error) {
            console.log("====================================");
            console.log(error);
            console.log("====================================");
        }
    },
    selectCategory(e) {
        this.category = e.target.value;

        if( this.category === 'my-section'){
            this.changeInpuTypeToggle = true;

            return
        }

        this.changeInpuTypeToggle = false;
    },
}));

Alpine.data("checkDateIsPast", () => ({
    message: null,
    selectedDate: null,
    init() {
        this.$watch("selectedDate", () => {
            this.checker();

            console.log("====================================");
            console.log(this.message);
            console.log("====================================");
        });
    },
    checker() {
        const currentDate = new Date().toJSON().slice(0, 10);
        const date2 = new Date(currentDate).getTime();
        const date1 = new Date(this.selectedDate).getTime();

        if (date2 < date1) {
            this.message = null;
            return;
        }

        this.message = "selected Date is in past";
    },
}));


Alpine.data('adminEventAttendances', () => ({
    search : null,
    attendances : [],
    event_id : null,
    initAttendances (data, eventId){

        console.log('====================================');
        console.log(data);
        console.log('====================================');
        this.attendances = [...data]
        this.event_id = eventId;
    },

    init(){
        this.$watch('search', () => {
            this.searchAttendances();
        })
    },
    async searchAttendances (){
        try {

            const response = await axios.get(`/events/${this.event_id}/attendances?search=${this.search}`)

            this.attendances = [...response.data]

            console.log('====================================');
            console.log('response', response.data);
            console.log('====================================');

        } catch (error) {
            console.log('====================================');
            console.log(error);
            console.log('====================================');
        }
    }
}));

Alpine.start();
