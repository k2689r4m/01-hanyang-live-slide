{{--<?php //phpinfo() ?>--}}

{{--<script src="{{ asset('js/d3.js') }}"></script>--}}

{{--<div class="row" style="margin: 0">--}}
{{--    <div class="col-sm-12">--}}
{{--        차트 테스트--}}
{{--    </div>--}}

{{--        <div id="graph" style="width: 500px;height: 500px">--}}
{{--        </div>--}}
{{--    <div>--}}
{{--        <svg id="graph"></svg>--}}
{{--    </div>--}}
{{--    <img src="img/checkRight.png" class="dn"/>--}}

{{--</div>--}}

{{--<style>--}}
{{--    .domain {--}}
{{--        stroke: #d5d5de;--}}
{{--        stroke-width: 0.7px;--}}

{{--        /*opacity: 0;*/--}}
{{--    }--}}

{{--    line {--}}
{{--        opacity: 0;--}}
{{--    }--}}

{{--    svg {--}}
{{--        -webkit-touch-callout: none;--}}
{{--        -webkit-user-select: none;--}}
{{--        -khtml-user-select: none;--}}
{{--        -moz-user-select: none;--}}
{{--        -ms-user-select: none;--}}
{{--        user-select: none;--}}
{{--    }--}}
{{--</style>--}}

{{--<script>--}}
{{--    const handleDnoutChart = () => {--}}
{{--        const width = 500;--}}
{{--        const height = 500;--}}
{{--        const data = [--}}
{{--            {name: 'A', value: 1000, color: '#efa86b'},--}}
{{--            {name: 'B', value: 1500, color: '#c1484f'},--}}
{{--            {name: 'C', value: 1300, color: '#d35d50'},--}}
{{--            {name: 'D', value: 900, color: '#f4c17c'},--}}
{{--            {name: 'E', value: 400, color: '#fae8a4'},--}}
{{--            {name: 'F', value: 1200, color: '#df7454'},--}}
{{--            {name: 'G', value: 1100, color: '#e88d5d'},--}}
{{--            {name: 'H', value: 600, color: '#f8d690'}--}}
{{--        ];--}}

{{--        const arc = d3.arc().innerRadius(150).outerRadius(Math.min(width, height) / 2);--}}

{{--        const arcLabel = (() => {--}}
{{--            const radius = Math.min(width, height) / 2 * 0.8;--}}
{{--            return d3.arc().innerRadius(radius).outerRadius(radius);--}}
{{--        })();--}}
{{--// 라벨이 위치할 반지름 값을 설정합니다.--}}

{{--        const pie = d3.pie()--}}
{{--            // 새로운 기본값의 파이 모양의 생성--}}
{{--            .sort((a, b) => b.value - a.value)--}}
{{--            // data의 value 큰값 > 작은값 순으로 정렬합니다. ex. 반대 순서는 a.value - b.value--}}
{{--            .value(d => d.value);--}}

{{--        const arcs = pie(data);--}}

{{--        const svg = d3.select('body').append('svg').style('width', width).style('height', height)--}}
{{--            .attr('text-anchor', 'middle')--}}
{{--            // text-anchor 텍스트의 정렬을 설정합니다 ( start | middle | end | inherit )--}}
{{--            .style('font-size', '12px sans-serif');--}}

{{--        const g = svg.append('g')--}}
{{--            .attr('transform', `translate(${width/2}, ${height/2})`);--}}
{{--        // 우선 차트를 그릴 그룹 엘리먼트를 추가합니다.--}}
{{--        // 위치값을 각각 2로 나누는건 반지름 값을 기준으로 한바퀴 돌며 path를 그리기 때문인거 같습니다.--}}

{{--        g.selectAll('path')--}}
{{--            .data(arcs)--}}
{{--            .enter().append('path')--}}
{{--            // 이전과 동일하게 가상 path 요소를 만들고 그래프 데이터와 매핑하여 엘리먼트를 추가합니다.--}}
{{--            .attr('fill', d => d.data.color)--}}
{{--            // 다른 그래프와 다르게 .data 라는 객체가 추가되어 있는데, 위에 arcs 변수를 선언할때--}}
{{--            // .pie(data)가 {data, value, index, startAngle, endAngle, padAngle} 의 값을 가지고 있습니다.--}}
{{--            .attr('stroke', 'white')--}}
{{--            .attr('d', arc)--}}
{{--            .append('title')--}}
{{--            .text(d => `${d.data.name}: ${d.data.value}`);--}}
{{--        // 각각 페스의 자식으로 title의 엘리먼트에 텍스트로 출력합니다.--}}
{{--        // 실제로 뷰에 출력되지는 않지만 시멘틱하게 각각의 요소의 설명 문자열을 제공합니다.--}}

{{--        const text = g.selectAll('text')--}}
{{--            .data(arcs)--}}
{{--            .enter().append('text')--}}
{{--            .attr('transform', d => `translate(${arcLabel.centroid(d)})`)--}}
{{--            .attr('dy', '0.35em');--}}
{{--        // 라벨을 취가하기 위한 text 엘리먼트를 만들고 위치를 지정합니다.--}}

{{--        text.append('tspan')--}}
{{--            .attr('x', 0)--}}
{{--            .attr('y', '-0.7em')--}}
{{--            .style('font-weight', 'bold')--}}
{{--            .text(d => d.data.name)--}}
{{--        // 해당 데이터 항목의 이름을 두꺼운 글씨로 출력합니다. ex. A--}}

{{--        text.filter(d => (d.endAngle - d.startAngle > 0.25)).append('tspan')--}}
{{--            .attr('x', 0)--}}
{{--            .attr('y', '0.7em')--}}
{{--            .attr('fill-opacity', 0.7)--}}
{{--            .text(d => d.data.value);--}}
{{--        // 해당 데이터의 수치값을 투명도를 주어 출력합니다. ex. 1000--}}

{{--        svg.node();--}}

{{--        d3.select('svg').appendChild(svg.node());--}}
{{--    }--}}

{{--    const handlePiChart = () => {--}}
{{--        const data = [--}}
{{--            {name: "<5", value: 19912018},--}}
{{--            {name: "5-9", value: 20501982},--}}
{{--            {name: "10-14", value: 20679786},--}}
{{--            {name: "15-19", value: 21354481},--}}
{{--            {name: "20-24", value: 22604232},--}}
{{--            {name: "25-29", value: 21698010},--}}
{{--            {name: "30-34", value: 21183639},--}}
{{--            {name: "35-39", value: 19855782},--}}
{{--            {name: "40-44", value: 20796128},--}}
{{--            {name: "45-49", value: 21370368},--}}
{{--            {name: "50-54", value: 22525490},--}}
{{--            {name: "55-59", value: 21001947},--}}
{{--            {name: "60-64", value: 18415681},--}}
{{--            {name: "65-69", value: 14547446},--}}
{{--            {name: "70-74", value: 10587721},--}}
{{--            {name: "75-79", value: 7730129},--}}
{{--            {name: "80-84", value: 5811429},--}}
{{--            {name: "≥85", value: 5938752}--}}
{{--        ];--}}

{{--        const color = d3.scaleOrdinal()--}}
{{--            .domain(data.map(d => d.name))--}}
{{--            .range(d3.quantize(t => d3.interpolateSpectral(t * 0.8 + 0.1), data.length).reverse());--}}

{{--        const width = 500;--}}
{{--        const height = Math.min(width, 500);--}}

{{--        const arc = d3.arc()--}}
{{--            .innerRadius(0)--}}
{{--            .outerRadius(Math.min(width, height) / 2 - 1);--}}

{{--        const pie = d3.pie()--}}
{{--            .sort(null)--}}
{{--            .value(d => d.value);--}}

{{--        const arcs = pie(data);--}}

{{--        // const svg = d3.create("svg")--}}
{{--        //     .attr("viewBox", [-width / 2, -height / 2, width, height]);--}}

{{--        const svg = d3.select('#graph').append('svg').attr('viewBox', [-width / 2, -height / 2, width, height]);--}}

{{--        const radius = Math.min(width, height) / 2 * 0.8;--}}
{{--        const arcLabel = d3.arc().innerRadius(radius).outerRadius(radius);--}}

{{--        svg.append("g")--}}
{{--            .attr("stroke", "white")--}}
{{--            .selectAll("path")--}}
{{--            .data(arcs)--}}
{{--            .join("path")--}}
{{--            .attr("fill", d => color(d.data.name))--}}
{{--            .attr("d", arc)--}}
{{--            .append("title")--}}
{{--            .text(d => `${d.data.name}: ${d.data.value.toLocaleString()}`);--}}

{{--        svg.append("g")--}}
{{--            .attr("font-family", "sans-serif")--}}
{{--            .attr("font-size", 12)--}}
{{--            .attr("text-anchor", "middle")--}}
{{--            .selectAll("text")--}}
{{--            .data(arcs)--}}
{{--            .join("text")--}}
{{--            .attr("transform", d => `translate(${arcLabel.centroid(d)})`)--}}
{{--            .call(text => text.append("tspan")--}}
{{--                .attr("y", "-0.4em")--}}
{{--                .attr("font-weight", "bold")--}}
{{--                .text(d => d.data.name))--}}
{{--            .call(text => text.filter(d => (d.endAngle - d.startAngle) > 0.25).append("tspan")--}}
{{--                .attr("x", 0)--}}
{{--                .attr("y", "0.7em")--}}
{{--                .attr("fill-opacity", 0.7)--}}
{{--                .text(d => d.data.value.toLocaleString()));--}}

{{--        // console.log(d3.select('#graph'));--}}
{{--        // d3.select('#graph').appendItem(svg.node());--}}
{{--    }--}}

{{--    const handleBarChart = (/** add parameter data */) => {--}}
{{--        /**--}}
{{--         *--}}
{{--         *  data format--}}
{{--         *  type: array[object] (php ? array[array])--}}
{{--         *--}}
{{--         *  array[--}}
{{--         *      object {--}}
{{--         *          name: string('title')--}}
{{--         *          value: integer('count of data')--}}
{{--         *          image: uri('link of image') ? if not exist -> null--}}
{{--         *          isRightAnswer: boolean('isRightAnswer')--}}
{{--         *          selectedAnswer: boolean('selectedAnswer')--}}
{{--         *      }--}}
{{--         *  ]--}}
{{--         */--}}

{{--        //remove following test data set when it use--}}
{{--        const data = [--}}
{{--            {name:'A', value:69, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-54-5fba7f4ac7faf.jpeg', isRightAnswer: false, selectedAnswer: false },--}}
{{--            {name:'B', value:19, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-55-5fba7f5567f37.jpeg', isRightAnswer: false, selectedAnswer: false },--}}
{{--            {name:'C', value:29, image:null, isRightAnswer: false, selectedAnswer: false },--}}
{{--            {name:'D', value:39, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-54-5fba7f4ac7faf.jpeg', isRightAnswer: false, selectedAnswer: false },--}}
{{--            {name:'E', value:29, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-55-5fba7f5567f37.jpeg', isRightAnswer: true, selectedAnswer: false },--}}
{{--            {name:'F', value:19, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-78-5fbb4fce6f529.jpeg', isRightAnswer: false, selectedAnswer: true },--}}
{{--            {name:'G', value:9 , image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-79-5fbb4fd39c2d9.jpeg', isRightAnswer: false, selectedAnswer: false },--}}

{{--            ];--}}

{{--        margin = ({top: 50, right: 0, bottom: 130, left: 0})--}}
{{--        height = 500--}}
{{--        width = 1000--}}
{{--        color = "steelblue"--}}

{{--        y = d3.scaleLinear()--}}
{{--            .domain([0, d3.max(data, d => d.value)]).nice()--}}
{{--            .range([height - margin.bottom, margin.top])--}}

{{--        x = d3.scaleBand()--}}
{{--            .domain(d3.range(data.length))--}}
{{--            .range([margin.left, width - margin.right])--}}
{{--            .padding(0.1)--}}

{{--        yAxis = g => g--}}
{{--            .attr("transform", `translate(${margin.left},0)`)--}}
{{--            .call(d3.axisLeft(y).ticks(null, data.format))--}}
{{--            .call(g => g.select(".domain").remove())--}}
{{--            .call(g => g.append("text")--}}
{{--                .attr("x", -margin.left)--}}
{{--                .attr("y", 10)--}}
{{--                .attr("fill", "currentColor")--}}
{{--                .attr("text-anchor", "start")--}}
{{--                .text(data.y))--}}

{{--        xAxis = g => g--}}
{{--            .attr("transform", `translate(0,${height - margin.bottom})`)--}}
{{--                .call(d3.axisBottom(x).tickFormat(i => data[i].name).tickSizeOuter(0))--}}

{{--        const svg = d3.select("svg")--}}
{{--            .attr("viewBox", [0, 0, width, height]);--}}

{{--        function rightRoundedRect(x, y, width, height, radius) {--}}
{{--            return "M" + x + "," + (y + radius)--}}
{{--                + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + -radius--}}
{{--                + "h" + (width - radius * 2)--}}
{{--                + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + radius--}}
{{--                + "v" + (height - radius)--}}
{{--                + "h" + ( - width)--}}
{{--                + "z";--}}
{{--        }--}}

{{--        svg.append('g')--}}
{{--            .selectAll('path').data(data).enter().append('path')--}}
{{--            .attr('fill', (d, i) => {--}}
{{--                if (data[i].isRightAnswer) {--}}
{{--                    return `#72c5ca`--}}
{{--                } else if (!data[i].isRightAnswer && data[i].selectedAnswer) {--}}
{{--                    return `#fe5579`--}}
{{--                } else {--}}
{{--                    return `#d5d5dd`--}}
{{--                }--}}
{{--            })--}}
{{--            .attr("d", (d, i) => {--}}
{{--                return rightRoundedRect(x(i) + (x.bandwidth() / 2 - 10), y(d.value), 20, y(0) - y(d.value), 10)--}}
{{--            });--}}

{{--        svg.append("g")--}}
{{--            .call(xAxis);--}}

{{--        d3.selectAll('.tick').each(function (d, i) {--}}
{{--            d3.select(this)--}}
{{--                .append('image')--}}
{{--                .attr('xlink:href', i < data.length ? data[i].image : null)--}}
{{--                .attr('x', - (x.bandwidth() / 2))--}}
{{--                .attr('y', 1)--}}
{{--                .attr('width',x.bandwidth())--}}
{{--                .attr('height', '100')--}}
{{--            ;--}}
{{--        })--}}

{{--        d3.selectAll('.tick').each(function (d, i) {--}}
{{--            d3.select(this)--}}
{{--                .append('image')--}}
{{--                .attr('xlink:href',  () => { if (data[i].isRightAnswer) { return `{{ URL::asset('img/checkRight.png') }}` } else if (!data[i].isRightAnswer && data[i].selectedAnswer) { return `{{ URL::asset('img/checkWrong.png') }}` } else { return `{{ URL::asset('img/checkWrongDisable.png') }}` } })--}}
{{--                .attr('x', -10)--}}
{{--                .attr('y', y(data[i].value + 92))--}}
{{--                .attr('width','20')--}}
{{--                .attr('height', '20')--}}
{{--            ;--}}
{{--        })--}}

{{--        d3.selectAll('text').each(function (d, i) {--}}
{{--            d3.select(this)--}}
{{--            .attr('stroke', () => {--}}
{{--                if (data[i].isRightAnswer) {--}}
{{--                    return `#72c5ca`--}}
{{--                } else if (!data[i].isRightAnswer && data[i].selectedAnswer) {--}}
{{--                    return `#fe5579`--}}
{{--                } else {--}}
{{--                    return `#d5d5dd`--}}
{{--                }--}}
{{--            })--}}
{{--            .attr('y', function () { if (data[i].image) { return 110 } else { return 10 } })--}}
{{--            .attr('font-size', '1rem')--}}
{{--        })--}}

{{--        d3.selectAll('.tick').each(function (d, i) {--}}
{{--            d3.select(this)--}}
{{--                .append('text')--}}
{{--                .text(data[i].value)--}}
{{--                .attr('x', 0)--}}
{{--                .attr('y', y(data[i].value + 83))--}}
{{--                .attr("stroke", "#828291")--}}
{{--                .attr('font-size', '1rem')--}}
{{--                .attr("text-anchor", "middle")--}}
{{--            ;--}}
{{--        })--}}
{{--    }--}}

{{--    const handleDashBoard = (/** add parameter data */) => {--}}
{{--        /**--}}
{{--         *--}}
{{--         *  data format--}}
{{--         *  type: array[object] (php ? array[array])--}}
{{--         *--}}
{{--         *  array [--}}
{{--         *      object {--}}
{{--         *          name: string('title')--}}
{{--         *          value: integer('count of data')--}}
{{--         *          image: uri('link of image') ? if not exist -> null--}}
{{--         *          isRightAnswer: boolean('isRightAnswer')--}}
{{--         *          selectedAnswer: boolean('selectedAnswer')--}}
{{--         *      },--}}
{{--         *      {}--}}
{{--         *  ]--}}
{{--         */--}}

{{--            //remove following test data set when it use--}}
{{--        const data = [--}}
{{--                {name:'USER NAME 1', value:100, rank:1, additionalScore:20},--}}
{{--                {name:'USER NAME 2', value:80, rank:2, additionalScore:20},--}}
{{--                {name:'USER NAME 3', value:65, rank:3, additionalScore:15},--}}
{{--                {name:'USER NAME 4', value:45, rank:4, additionalScore:15},--}}
{{--                {name:'USER NAME 5', value:44, rank:5, additionalScore:10},--}}
{{--                {name:'USER NAME 6', value:40, rank:6, additionalScore:10},--}}
{{--                {name:'USER NAME 7', value:38 , rank:7, additionalScore:5},--}}
{{--                {name:'USER NAME 8', value:36 , rank:8, additionalScore:5},--}}
{{--                {name:'USER NAME 9', value:30 , rank:9, additionalScore:5},--}}
{{--                {name:'USER NAME 10', value:27 , rank:10, additionalScore:5},--}}
{{--                {},--}}
{{--                {},--}}
{{--                {},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--            ];--}}

{{--        const colorSet = [--}}
{{--            '#FF6699',--}}
{{--            '#Ff9966',--}}
{{--            '#ffcc66',--}}
{{--            '#66cccc',--}}
{{--            '#6699cc',--}}
{{--            '#666699',--}}
{{--            '#9966cc',--}}
{{--            '#666666',--}}
{{--            '#666666',--}}
{{--            '#666666',--}}
{{--            '',--}}
{{--            '',--}}
{{--            '',--}}
{{--            '#666666',--}}
{{--        ]--}}

{{--        margin = ({top: 30, right: 40, bottom: 10, left: 120})--}}
{{--        barHeight = 40--}}
{{--        height = data.length >= 10 ? Math.ceil((data.length + 3 + 0.1) * barHeight) + margin.top + margin.bottom : Math.ceil((data.length + 0.1) * barHeight) + margin.top + margin.bottom--}}
{{--        width = height * 2--}}

{{--        yAxis = g => g--}}
{{--            .attr("transform", `translate(${margin.left},0)`)--}}
{{--            .attr("fill", `#666666`)--}}
{{--            .attr("stroke", `#666666`)--}}
{{--            .attr("stroke-width", `0.4`)--}}
{{--            .call(d3.axisLeft(y).tickFormat(i => data[i].name).tickSizeOuter(0)).attr('font-size', '0.9rem')--}}

{{--        xAxis = g => g--}}
{{--            .attr("transform", `translate(0,${margin.top})`)--}}
{{--            .call(d3.axisTop(x).ticks(width / 80, data.format))--}}
{{--            .call(g => g.select(".domain").remove())--}}

{{--        y = d3.scaleBand()--}}
{{--            .domain(d3.range(data.length))--}}
{{--            .rangeRound([margin.top, height - margin.bottom])--}}
{{--            .padding(0.1)--}}

{{--        x = d3.scaleLinear()--}}
{{--            .domain([0, d3.max(data, d => d.value)])--}}
{{--            .range([margin.left + 20, width - margin.right])--}}

{{--        format = x.tickFormat(20, data.format)--}}

{{--        const svg = d3.select("svg")--}}
{{--            .attr("viewBox", [0, 0, width, height]);--}}

{{--        function rightRoundedRect(x, y, width, height, radius) {--}}
{{--            return "M" + x + "," + y--}}
{{--                + "h" + (width - radius)--}}
{{--                + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + radius--}}
{{--                + "v" + (height - radius * 2)--}}
{{--                + "a" + radius + "," + radius + " 0 0 1 " + -radius + "," + radius--}}
{{--                + "h" + (radius - width)--}}
{{--                + "z";--}}
{{--        }--}}

{{--        svg.append('g')--}}
{{--            .selectAll('path').data(data).enter().append('path')--}}
{{--            .attr('fill', (d, i) => {--}}
{{--                return colorSet[i];--}}
{{--            })--}}
{{--            .attr("d", (d, i) => {--}}
{{--                if (i != 10 && i != 11 && i != 12) {--}}
{{--                    return rightRoundedRect(x(0), y(i) + y.bandwidth() / 4, x(d.value) - x(0), y.bandwidth() / 2, 8)--}}
{{--                }--}}
{{--                else {--}}

{{--                }--}}
{{--            })--}}
{{--        ;--}}

{{--        svg.append("g")--}}
{{--            // .attr("stroke", "white")--}}
{{--            // .attr("stroke-width", "0.7")--}}
{{--            .attr("text-anchor", "end")--}}
{{--            .attr("font-family", "sans-serif")--}}
{{--            .attr("font-size", 12)--}}
{{--            .selectAll("text")--}}
{{--            .data(data)--}}
{{--            .join("text")--}}
{{--            .attr("x", d => x(d.value))--}}
{{--            .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr("dy", "0.35em")--}}
{{--            .attr("dx", -4)--}}
{{--            .attr("fill", 'white')--}}
{{--            .attr("stroke", 'white')--}}
{{--            .attr("stroke-width", '0.5')--}}
{{--            .text(d => d.value+'점')--}}
{{--            .call(text => text.filter(d => x(d.value) - x(0) < 20) // short bars--}}
{{--                .attr("dx", +4)--}}
{{--                .attr("fill", "white")--}}
{{--                .attr("text-anchor", "start")--}}
{{--            );--}}

{{--        let _i = 0;--}}

{{--        svg.append("g")--}}
{{--            // .attr("stroke", colorSet[_i++])--}}
{{--            // .attr("stroke-width", "0.7")--}}
{{--            .attr("text-anchor", "start")--}}
{{--            .attr("font-family", "sans-serif")--}}
{{--            .attr("font-size", 12)--}}
{{--            .selectAll("text")--}}
{{--            .data(data)--}}
{{--            .join("text")--}}
{{--            .attr("x", d => x(d.value) + 10)--}}
{{--            .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr("dy", "0.35em")--}}
{{--            .attr("dx", -4)--}}
{{--            .attr("stroke", () => colorSet[_i++])--}}
{{--            .text(d => d.additionalScore ? '+' + d.additionalScore : '')--}}
{{--            .call(text => text.filter(d => x(d.value) - x(0) < 20) // short bars--}}
{{--                // .attr("fill", colorSet[_i++])--}}
{{--                .attr("text-anchor", "start"));--}}

{{--        svg.append("g")--}}
{{--            .attr("fill", "white")--}}
{{--            // .attr("stroke-width", "0.7")--}}
{{--            .selectAll("circle")--}}
{{--            .data(data)--}}
{{--            .join('circle')--}}
{{--            // .attr("x", d => margin.left + 5)--}}
{{--            // .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr('cx', d => margin.left + 13)--}}
{{--            .attr('cy', (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr('r', 12)--}}
{{--            .attr('stroke', (d, i) => colorSet[i])--}}
{{--            .attr('stroke-width', '2')--}}

{{--        svg.append("g")--}}
{{--            .attr("stroke", "black")--}}
{{--            .attr("stroke-width", "0.4")--}}
{{--            .attr("text-anchor", "middle")--}}
{{--            .attr("font-family", "sans-serif")--}}
{{--            .attr("font-size", 12)--}}
{{--            .selectAll("text")--}}
{{--            .data(data)--}}
{{--            .join("text")--}}
{{--            .attr("x", d => margin.left + 17)--}}
{{--            .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr("dy", "0.35em")--}}
{{--            .attr("dx", -4)--}}
{{--            .text((d, i) => d.rank)--}}
{{--            .call(text => text.filter(d => x(d.value) - x(0) < 20) // short bars--}}
{{--                .attr("fill", "black")--}}
{{--                .attr("text-anchor", "middle"));--}}

{{--        // svg.append("g")--}}
{{--        //     .call(xAxis);--}}

{{--        if (data.length > 10) {--}}
{{--            for (let i = 10;i <= 12;i++) {--}}
{{--                svg.append('circle')--}}
{{--                    .attr('cx', height)--}}
{{--                    .attr('cy', y(i) + y.bandwidth() / 2)--}}
{{--                    .attr('r', 4)--}}
{{--                    .attr('stroke', '#666666')--}}
{{--                    .attr('stroke-width', '1')--}}
{{--            }--}}
{{--        }--}}


{{--        svg.append("g")--}}
{{--            .call(yAxis);--}}
{{--    }--}}

{{--    const handleMakeWordCloud = () => {--}}
{{--        const randWords = [];--}}

{{--        for (let i = 0;i < 100;i++) {--}}
{{--            randWords.push(`${i}`);--}}
{{--        }--}}

{{--        const colors = ['#f9c0c0', '#f6d6ad', '#fafcc2', '#ccf6c8', '#ddf3f5', '#6886c5', '#b590ca'];--}}

{{--        var layout = d3.layout.cloud()--}}
{{--            .size([500, 500])--}}
{{--            .words(randWords.map(function(d) { return {text: d, size: 10 + Math.random() * 90}; }))--}}
{{--            .padding(5)--}}
{{--            .rotate(function() { return (~~(Math.random() * 6) - 3) * 30; })--}}
{{--            .font("Impact")--}}
{{--            .fontSize(function(d) { return d.size; })--}}
{{--            .on("end", draw);--}}

{{--        layout.start();--}}

{{--        function draw(words) {--}}
{{--            d3.select("#graph").append("svg")--}}
{{--                .attr("width", layout.size()[0])--}}
{{--                .attr("height", layout.size()[1])--}}
{{--                .append("g")--}}
{{--                .attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")")--}}
{{--                .selectAll("text")--}}
{{--                .data(words)--}}
{{--                .enter().append("text")--}}
{{--                .style("font-size", function(d) { return d.size + "px"; })--}}
{{--                .style("font-family", "Impact")--}}
{{--                .style('fill', function (d, i) {--}}
{{--                    let rand = Math.round(Math.random() * 7);--}}
{{--                    rand = rand === 7 ? 6 : rand;--}}

{{--                    return colors[rand];--}}
{{--                })--}}
{{--                .attr("text-anchor", "middle")--}}
{{--                .attr("transform", function(d) {--}}
{{--                    return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";--}}
{{--                })--}}
{{--                .text(function(d) { return d.text; });--}}
{{--        }--}}
{{--    }--}}

{{--    const handleDashBoardProfessor = () => {--}}
{{--        /**--}}
{{--         *--}}
{{--         *  data format--}}
{{--         *  type: array[object] (php ? array[array])--}}
{{--         *--}}
{{--         *  array [--}}
{{--         *      object {--}}
{{--         *          name: string('title')--}}
{{--         *          value: integer('count of data')--}}
{{--         *          image: uri('link of image') ? if not exist -> null--}}
{{--         *          isRightAnswer: boolean('isRightAnswer')--}}
{{--         *          selectedAnswer: boolean('selectedAnswer')--}}
{{--         *      },--}}
{{--         *      {}--}}
{{--         *  ]--}}
{{--         */--}}

{{--        //remove following test data set when it use--}}
{{--        const data = [--}}
{{--                {name:'USER NAME 1', value:100, rank:1, additionalScore:20},--}}
{{--                {name:'USER NAME 2', value:80, rank:2, additionalScore:20},--}}
{{--                {name:'USER NAME 3', value:65, rank:3, additionalScore:15},--}}
{{--                {name:'USER NAME 4', value:45, rank:4, additionalScore:15},--}}
{{--                {name:'USER NAME 5', value:44, rank:5, additionalScore:10},--}}
{{--                {name:'USER NAME 6', value:40, rank:6, additionalScore:10},--}}
{{--                {name:'USER NAME 7', value:38 , rank:7, additionalScore:5},--}}
{{--                {name:'USER NAME 8', value:36 , rank:8, additionalScore:5},--}}
{{--                {name:'USER NAME 9', value:30 , rank:9, additionalScore:5},--}}
{{--                {name:'USER NAME 10', value:27 , rank:10, additionalScore:5},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--                {name:'USER NAME 11', value:1 , rank:270, additionalScore:1},--}}
{{--            ];--}}

{{--        const colorSet = [--}}
{{--            '#FF6699',--}}
{{--            '#Ff9966',--}}
{{--            '#ffcc66',--}}
{{--            '#66cccc',--}}
{{--            '#6699cc',--}}
{{--            '#666699',--}}
{{--            '#9966cc',--}}
{{--            '#666666',--}}
{{--            '#666666',--}}
{{--            '#666666',--}}
{{--            '#666666',--}}
{{--        ]--}}

{{--        margin = ({top: 30, right: 40, bottom: 10, left: 120})--}}
{{--        barHeight = 40--}}
{{--        height = Math.ceil((data.length + 0.1) * barHeight) + margin.top + margin.bottom--}}
{{--        width = 1000--}}

{{--        yAxis = g => g--}}
{{--            .attr("transform", `translate(${margin.left},0)`)--}}
{{--            .attr("fill", `#666666`)--}}
{{--            .attr("stroke", `#666666`)--}}
{{--            .attr("stroke-width", `0.4`)--}}
{{--            .call(d3.axisLeft(y).tickFormat(i => data[i].name).tickSizeOuter(0)).attr('font-size', '0.9rem')--}}

{{--        xAxis = g => g--}}
{{--            .attr("transform", `translate(0,${margin.top})`)--}}
{{--            .call(d3.axisTop(x).ticks(width / 80, data.format))--}}
{{--            .call(g => g.select(".domain").remove())--}}

{{--        y = d3.scaleBand()--}}
{{--            .domain(d3.range(data.length))--}}
{{--            .rangeRound([margin.top, height - margin.bottom])--}}
{{--            .padding(0.1)--}}

{{--        x = d3.scaleLinear()--}}
{{--            .domain([0, d3.max(data, d => d.value)])--}}
{{--            .range([margin.left + 20, width - margin.right])--}}

{{--        format = x.tickFormat(20, data.format)--}}

{{--        const svg = d3.select("svg")--}}
{{--            .attr("viewBox", [0, 0, width, height]);--}}

{{--        function rightRoundedRect(x, y, width, height, radius) {--}}
{{--            return "M" + x + "," + y--}}
{{--                + "h" + (width - radius)--}}
{{--                + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + radius--}}
{{--                + "v" + (height - radius * 2)--}}
{{--                + "a" + radius + "," + radius + " 0 0 1 " + -radius + "," + radius--}}
{{--                + "h" + (radius - width)--}}
{{--                + "z";--}}
{{--        }--}}

{{--        svg.append('g')--}}
{{--            .selectAll('path').data(data).enter().append('path')--}}
{{--            .attr('fill', (d, i) => {--}}
{{--                if (i < 10) {--}}
{{--                    return colorSet[i];--}}
{{--                }--}}
{{--                else {--}}
{{--                    return colorSet[10];--}}
{{--                }--}}

{{--            })--}}
{{--            .attr("d", (d, i) => {--}}
{{--                return rightRoundedRect(x(0), y(i) + y.bandwidth() / 4, x(d.value) - x(0), y.bandwidth() / 2, 8)--}}
{{--            })--}}
{{--        ;--}}

{{--        svg.append("g")--}}
{{--            // .attr("stroke", "white")--}}
{{--            // .attr("stroke-width", "0.7")--}}
{{--            .attr("text-anchor", "end")--}}
{{--            .attr("font-family", "sans-serif")--}}
{{--            .attr("font-size", 12)--}}
{{--            .selectAll("text")--}}
{{--            .data(data)--}}
{{--            .join("text")--}}
{{--            .attr("x", d => x(d.value))--}}
{{--            .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr("dy", "0.35em")--}}
{{--            .attr("dx", -4)--}}
{{--            .attr("fill", 'white')--}}
{{--            .attr("stroke", 'white')--}}
{{--            .attr("stroke-width", '0.5')--}}
{{--            .text(d => d.value+'점')--}}
{{--            .call(text => text.filter(d => x(d.value) - x(0) < 20) // short bars--}}
{{--                .attr("dx", +4)--}}
{{--                .attr("fill", "white")--}}
{{--                .attr("text-anchor", "start")--}}
{{--            );--}}

{{--        let _i = 0;--}}

{{--        svg.append("g")--}}
{{--            // .attr("stroke", colorSet[_i++])--}}
{{--            // .attr("stroke-width", "0.7")--}}
{{--            .attr("text-anchor", "start")--}}
{{--            .attr("font-family", "sans-serif")--}}
{{--            .attr("font-size", 12)--}}
{{--            .selectAll("text")--}}
{{--            .data(data)--}}
{{--            .join("text")--}}
{{--            .attr("x", d => x(d.value) + 10)--}}
{{--            .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr("dy", "0.35em")--}}
{{--            .attr("dx", -4)--}}
{{--            .attr("stroke", () => _i < 10 ? colorSet[_i++] : colorSet[10])--}}
{{--            .text(d => d.additionalScore ? `+${d.additionalScore}` : '')--}}
{{--            .call(text => text.filter(d => x(d.value) - x(0) < 20) // short bars--}}
{{--                // .attr("fill", colorSet[_i++])--}}
{{--                .attr("text-anchor", "start"));--}}

{{--        svg.append("g")--}}
{{--            .attr("fill", "white")--}}
{{--            // .attr("stroke-width", "0.7")--}}
{{--            .selectAll("circle")--}}
{{--            .data(data)--}}
{{--            .join('circle')--}}
{{--            // .attr("x", d => margin.left + 5)--}}
{{--            // .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr('cx', d => margin.left + 13)--}}
{{--            .attr('cy', (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr('r', 12)--}}
{{--            .attr('stroke', (d, i) => i < 10 ? colorSet[i] : colorSet[10])--}}
{{--            .attr('stroke-width', '2')--}}

{{--        svg.append("g")--}}
{{--            .attr("stroke", "black")--}}
{{--            .attr("stroke-width", "0.4")--}}
{{--            .attr("text-anchor", "middle")--}}
{{--            .attr("font-family", "sans-serif")--}}
{{--            .attr("font-size", 12)--}}
{{--            .selectAll("text")--}}
{{--            .data(data)--}}
{{--            .join("text")--}}
{{--            .attr("x", d => margin.left + 17)--}}
{{--            .attr("y", (d, i) => y(i) + y.bandwidth() / 2)--}}
{{--            .attr("dy", "0.35em")--}}
{{--            .attr("dx", -4)--}}
{{--            .text((d, i) => d.rank)--}}
{{--            .call(text => text.filter(d => x(d.value) - x(0) < 20) // short bars--}}
{{--                .attr("fill", "black")--}}
{{--                .attr("text-anchor", "middle"));--}}

{{--        // svg.append("g")--}}
{{--        //     .call(xAxis);--}}


{{--        svg.append("g")--}}
{{--            .call(yAxis);--}}
{{--    }--}}

{{--    window.onload = () => {--}}
{{--        // handleBarChart();--}}
{{--        // handleDashBoard();--}}
{{--        handleDashBoardProfessor();--}}
{{--    }--}}
{{--</script>--}}

