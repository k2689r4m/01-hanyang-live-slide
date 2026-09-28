<div class="row" style="margin: 0">
    <div class="col-sm-12">
        차트 테스트
    </div>

{{--    <div id="graph" style="width: 500px;height: 500px">--}}
{{--    </div>--}}
    <div>
        <svg id="graph" width="500" height="500"></svg>
    </div>

</div>

@section('onloadChart')
    handleMakeWordCloud();
{{--    handleBarChart();--}}
{{--handleDnoutChart();--}}
{{--handlePiChart();--}}
@endsection


@section('chartScript')
    <script>
        const handleDnoutChart = () => {
            const width = 500;
            const height = 500;
            const data = [
                {name: 'A', value: 1000, color: '#efa86b'},
                {name: 'B', value: 1500, color: '#c1484f'},
                {name: 'C', value: 1300, color: '#d35d50'},
                {name: 'D', value: 900, color: '#f4c17c'},
                {name: 'E', value: 400, color: '#fae8a4'},
                {name: 'F', value: 1200, color: '#df7454'},
                {name: 'G', value: 1100, color: '#e88d5d'},
                {name: 'H', value: 600, color: '#f8d690'}
            ];

            const arc = d3.arc().innerRadius(150).outerRadius(Math.min(width, height) / 2);

            const arcLabel = (() => {
                const radius = Math.min(width, height) / 2 * 0.8;
                return d3.arc().innerRadius(radius).outerRadius(radius);
            })();
// 라벨이 위치할 반지름 값을 설정합니다.

            const pie = d3.pie()
                // 새로운 기본값의 파이 모양의 생성
                .sort((a, b) => b.value - a.value)
                // data의 value 큰값 > 작은값 순으로 정렬합니다. ex. 반대 순서는 a.value - b.value
                .value(d => d.value);

            const arcs = pie(data);

            const svg = d3.select('body').append('svg').style('width', width).style('height', height)
                .attr('text-anchor', 'middle')
                // text-anchor 텍스트의 정렬을 설정합니다 ( start | middle | end | inherit )
                .style('font-size', '12px sans-serif');

            const g = svg.append('g')
                .attr('transform', `translate(${width/2}, ${height/2})`);
            // 우선 차트를 그릴 그룹 엘리먼트를 추가합니다.
            // 위치값을 각각 2로 나누는건 반지름 값을 기준으로 한바퀴 돌며 path를 그리기 때문인거 같습니다.

            g.selectAll('path')
                .data(arcs)
                .enter().append('path')
                // 이전과 동일하게 가상 path 요소를 만들고 그래프 데이터와 매핑하여 엘리먼트를 추가합니다.
                .attr('fill', d => d.data.color)
                // 다른 그래프와 다르게 .data 라는 객체가 추가되어 있는데, 위에 arcs 변수를 선언할때
                // .pie(data)가 {data, value, index, startAngle, endAngle, padAngle} 의 값을 가지고 있습니다.
                .attr('stroke', 'white')
                .attr('d', arc)
                .append('title')
                .text(d => `${d.data.name}: ${d.data.value}`);
            // 각각 페스의 자식으로 title의 엘리먼트에 텍스트로 출력합니다.
            // 실제로 뷰에 출력되지는 않지만 시멘틱하게 각각의 요소의 설명 문자열을 제공합니다.

            const text = g.selectAll('text')
                .data(arcs)
                .enter().append('text')
                .attr('transform', d => `translate(${arcLabel.centroid(d)})`)
                .attr('dy', '0.35em');
            // 라벨을 취가하기 위한 text 엘리먼트를 만들고 위치를 지정합니다.

            text.append('tspan')
                .attr('x', 0)
                .attr('y', '-0.7em')
                .style('font-weight', 'bold')
                .text(d => d.data.name)
            // 해당 데이터 항목의 이름을 두꺼운 글씨로 출력합니다. ex. A

            text.filter(d => (d.endAngle - d.startAngle > 0.25)).append('tspan')
                .attr('x', 0)
                .attr('y', '0.7em')
                .attr('fill-opacity', 0.7)
                .text(d => d.data.value);
            // 해당 데이터의 수치값을 투명도를 주어 출력합니다. ex. 1000

            svg.node();

            d3.select('svg').appendChild(svg.node());
        }

        const handlePiChart = () => {
            const data = [
                {name: "<5", value: 19912018},
                {name: "5-9", value: 20501982},
                {name: "10-14", value: 20679786},
                {name: "15-19", value: 21354481},
                {name: "20-24", value: 22604232},
                {name: "25-29", value: 21698010},
                {name: "30-34", value: 21183639},
                {name: "35-39", value: 19855782},
                {name: "40-44", value: 20796128},
                {name: "45-49", value: 21370368},
                {name: "50-54", value: 22525490},
                {name: "55-59", value: 21001947},
                {name: "60-64", value: 18415681},
                {name: "65-69", value: 14547446},
                {name: "70-74", value: 10587721},
                {name: "75-79", value: 7730129},
                {name: "80-84", value: 5811429},
                {name: "≥85", value: 5938752}
            ];

            const color = d3.scaleOrdinal()
                .domain(data.map(d => d.name))
                .range(d3.quantize(t => d3.interpolateSpectral(t * 0.8 + 0.1), data.length).reverse());

            const width = 500;
            const height = Math.min(width, 500);

            const arc = d3.arc()
                .innerRadius(0)
                .outerRadius(Math.min(width, height) / 2 - 1);

            const pie = d3.pie()
                .sort(null)
                .value(d => d.value);

            const arcs = pie(data);

            // const svg = d3.create("svg")
            //     .attr("viewBox", [-width / 2, -height / 2, width, height]);

            const svg = d3.select('#graph').append('svg').attr('viewBox', [-width / 2, -height / 2, width, height]);

            const radius = Math.min(width, height) / 2 * 0.8;
            const arcLabel = d3.arc().innerRadius(radius).outerRadius(radius);

            svg.append("g")
                .attr("stroke", "white")
                .selectAll("path")
                .data(arcs)
                .join("path")
                .attr("fill", d => color(d.data.name))
                .attr("d", arc)
                .append("title")
                .text(d => `${d.data.name}: ${d.data.value.toLocaleString()}`);

            svg.append("g")
                .attr("font-family", "sans-serif")
                .attr("font-size", 12)
                .attr("text-anchor", "middle")
                .selectAll("text")
                .data(arcs)
                .join("text")
                .attr("transform", d => `translate(${arcLabel.centroid(d)})`)
                .call(text => text.append("tspan")
                    .attr("y", "-0.4em")
                    .attr("font-weight", "bold")
                    .text(d => d.data.name))
                .call(text => text.filter(d => (d.endAngle - d.startAngle) > 0.25).append("tspan")
                    .attr("x", 0)
                    .attr("y", "0.7em")
                    .attr("fill-opacity", 0.7)
                    .text(d => d.data.value.toLocaleString()));

            // console.log(d3.select('#graph'));
            // d3.select('#graph').appendItem(svg.node());
        }

        const handleBarChart = () => {
            const dataset = [{x:'A', y:69 }, {x:'B', y:19}, {x:'C', y:29}, {x:'D', y:39},
                {x:'E', y:29}, {x:'F', y:19}, {x:'G', y:9 }];

            const svg = d3.select("svg");
            const width  = parseInt(svg.style("width"), 10) -30;
            const height = parseInt(svg.style("height"), 10)-20;

            const svgG = svg.append("g")
                .attr("transform", "translate(30, 0)");

            const xScale = d3.scaleBand()
                .domain(dataset.map(function(d) { return d.x;} ))
                .range([0, width]).padding(0.2);

            const yScale = d3.scaleLinear()
                .domain([0, d3.max(dataset, function(d){ return d.y; })])
                .range([height, 0]);

            svgG.append("g")
                .attr("class", "grid")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(xScale)
                    .tickSize(-height)
                );

            svgG.append("g")
                .attr("class", "grid")
                .call(d3.axisLeft(yScale)
                    .ticks(5)
                    .tickSize(-width)
                );

            const barG = svgG.append("g");

            barG.selectAll("rect")
                .data(dataset)
                .enter().append("rect")
                .attr("class", "bar")
                .attr("height", function(d, i) {return height-yScale(d.y)})
                .attr("width", xScale.bandwidth())
                .attr("x", function(d, i) {return xScale(d.x)})
                .attr("y", function(d, i) {return yScale(d.y)})
                .on("mouseover", function(d) { tooltip.style("display", null); })
                .on("mouseout",  function() { tooltip.style("display", "none"); })
                .on("mousemove", function(d) {
                    tooltip.style("left", (d.pageX+10)+"px");
                    tooltip.style("top",  (d.pageY-10)+"px");
                    tooltip.html(d.target.__data__.x);
                });

            barG.selectAll("text")
                .data(dataset)
                .enter().append("text")
                .text(function(d) {return d.y})
                .attr("class", "text")
                .attr("x", function(d, i) {return xScale(d.x)+xScale.bandwidth()/2})
                .style("text-anchor", "middle")
                .attr("y", function(d, i) {return yScale(d.y) + 15});

            const tooltip = d3.select("body").append("div").attr("class", "toolTip").style("display", "none");

        }

        const handleMakeWordCloud = () => {
            const randWords = [];

            for (let i = 0;i < 100;i++) {
                randWords.push(`${i}`);
            }

            const colors = ['#f9c0c0', '#f6d6ad', '#fafcc2', '#ccf6c8', '#ddf3f5', '#6886c5', '#b590ca'];

            var layout = d3.layout.cloud()
                .size([500, 500])
                .words(randWords.map(function(d) { return {text: d, size: 10 + Math.random() * 90}; }))
                .padding(5)
                .rotate(function() { return (~~(Math.random() * 6) - 3) * 30; })
                .font("Impact")
                .fontSize(function(d) { return d.size; })
                .on("end", draw);

            layout.start();

            function draw(words) {
                d3.select("#graph").append("svg")
                    .attr("width", layout.size()[0])
                    .attr("height", layout.size()[1])
                    .append("g")
                    .attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")")
                    .selectAll("text")
                    .data(words)
                    .enter().append("text")
                    .style("font-size", function(d) { return d.size + "px"; })
                    .style("font-family", "Impact")
                    .style('fill', function (d, i) {
                        let rand = Math.round(Math.random() * 7);
                        rand = rand === 7 ? 6 : rand;

                        return colors[rand];
                    })
                    .attr("text-anchor", "middle")
                    .attr("transform", function(d) {
                        return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                    })
                    .text(function(d) { return d.text; });
            }
        }
    </script>
@endsection
