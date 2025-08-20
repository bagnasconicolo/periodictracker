
const elementsData = [
  {
    atomicNumber: 1,
    symbol: "H",
    name: "Hydrogen",
    category: "nonmetal",
    group: 1,
    period: 1,
    atomicMass: 1.008,
    briefDesc: "Lightest element, highly reactive nonmetal"
  },
  {
    atomicNumber: 2,
    symbol: "He",
    name: "Helium",
    category: "noble gas",
    group: 18,
    period: 1,
    atomicMass: 4.002602,
    briefDesc: "Colorless, odorless noble gas used in balloons"
  },
  {
    atomicNumber: 3,
    symbol: "Li",
    name: "Lithium",
    category: "alkali metal",
    group: 1,
    period: 2,
    atomicMass: 6.94,
    briefDesc: "Soft, silvery metal, lightest metal"
  },
  {
    atomicNumber: 4,
    symbol: "Be",
    name: "Beryllium",
    category: "alkaline earth metal",
    group: 2,
    period: 2,
    atomicMass: 9.0121831,
    briefDesc: "Hard, gray metal, toxic in some forms"
  },
  {
    atomicNumber: 5,
    symbol: "B",
    name: "Boron",
    category: "metalloid",
    group: 13,
    period: 2,
    atomicMass: 10.81,
    briefDesc: "Brittle, black metalloid used in semiconductors"
  },
  {
    atomicNumber: 6,
    symbol: "C",
    name: "Carbon",
    category: "nonmetal",
    group: 14,
    period: 2,
    atomicMass: 12.011,
    briefDesc: "Nonmetal with allotropes like diamond & graphite"
  },
  {
    atomicNumber: 7,
    symbol: "N",
    name: "Nitrogen",
    category: "nonmetal",
    group: 15,
    period: 2,
    atomicMass: 14.007,
    briefDesc: "Colorless gas, ~78% of Earth's atmosphere"
  },
  {
    atomicNumber: 8,
    symbol: "O",
    name: "Oxygen",
    category: "nonmetal",
    group: 16,
    period: 2,
    atomicMass: 15.999,
    briefDesc: "Colorless gas essential for aerobic life"
  },
  {
    atomicNumber: 9,
    symbol: "F",
    name: "Fluorine",
    category: "halogen",
    group: 17,
    period: 2,
    atomicMass: 18.998403163,
    briefDesc: "Pale yellow, highly reactive gas"
  },
  {
    atomicNumber: 10,
    symbol: "Ne",
    name: "Neon",
    category: "noble gas",
    group: 18,
    period: 2,
    atomicMass: 20.1797,
    briefDesc: "Inert gas used in neon signs"
  },
  {
    atomicNumber: 11,
    symbol: "Na",
    name: "Sodium",
    category: "alkali metal",
    group: 1,
    period: 3,
    atomicMass: 22.98976928,
    briefDesc: "Soft, reactive metal that tarnishes quickly"
  },
  {
    atomicNumber: 12,
    symbol: "Mg",
    name: "Magnesium",
    category: "alkaline earth metal",
    group: 2,
    period: 3,
    atomicMass: 24.305,
    briefDesc: "Light metal, burns with bright white flame"
  },
  {
    atomicNumber: 13,
    symbol: "Al",
    name: "Aluminum",
    category: "post-transition metal",
    group: 13,
    period: 3,
    atomicMass: 26.9815385,
    briefDesc: "Silvery metal used in aircraft, packaging"
  },
  {
    atomicNumber: 14,
    symbol: "Si",
    name: "Silicon",
    category: "metalloid",
    group: 14,
    period: 3,
    atomicMass: 28.085,
    briefDesc: "Semiconductor metalloid used in electronics"
  },
  {
    atomicNumber: 15,
    symbol: "P",
    name: "Phosphorus",
    category: "nonmetal",
    group: 15,
    period: 3,
    atomicMass: 30.974,
    briefDesc: "Multiple allotropes; vital in biology"
  },
  {
    atomicNumber: 16,
    symbol: "S",
    name: "Sulfur",
    category: "nonmetal",
    group: 16,
    period: 3,
    atomicMass: 32.06,
    briefDesc: "Yellow nonmetal used in sulfuric acid"
  },
  {
    atomicNumber: 17,
    symbol: "Cl",
    name: "Chlorine",
    category: "halogen",
    group: 17,
    period: 3,
    atomicMass: 35.45,
    briefDesc: "Greenish-yellow, reactive gas; used as disinfectant"
  },
  {
    atomicNumber: 18,
    symbol: "Ar",
    name: "Argon",
    category: "noble gas",
    group: 18,
    period: 3,
    atomicMass: 39.948,
    briefDesc: "Inert, colorless gas used in lighting"
  },
  {
    atomicNumber: 19,
    symbol: "K",
    name: "Potassium",
    category: "alkali metal",
    group: 1,
    period: 4,
    atomicMass: 39.0983,
    briefDesc: "Soft, reactive metal essential to biology"
  },
  {
    atomicNumber: 20,
    symbol: "Ca",
    name: "Calcium",
    category: "alkaline earth metal",
    group: 2,
    period: 4,
    atomicMass: 40.078,
    briefDesc: "Vital for bones, silvery metal"
  },
  {
    atomicNumber: 21,
    symbol: "Sc",
    name: "Scandium",
    category: "transition metal",
    group: 3,
    period: 4,
    atomicMass: 44.955908,
    briefDesc: "Light, silvery metal used in alloys"
  },
  {
    atomicNumber: 22,
    symbol: "Ti",
    name: "Titanium",
    category: "transition metal",
    group: 4,
    period: 4,
    atomicMass: 47.867,
    briefDesc: "Strong, light, corrosion-resistant metal"
  },
  {
    atomicNumber: 23,
    symbol: "V",
    name: "Vanadium",
    category: "transition metal",
    group: 5,
    period: 4,
    atomicMass: 50.9415,
    briefDesc: "Used to strengthen steel alloys"
  },
  {
    atomicNumber: 24,
    symbol: "Cr",
    name: "Chromium",
    category: "transition metal",
    group: 6,
    period: 4,
    atomicMass: 51.9961,
    briefDesc: "Lustrous, hard metal for stainless steel"
  },
  {
    atomicNumber: 25,
    symbol: "Mn",
    name: "Manganese",
    category: "transition metal",
    group: 7,
    period: 4,
    atomicMass: 54.938044,
    briefDesc: "Hard, brittle metal used in steel"
  },
  {
    atomicNumber: 26,
    symbol: "Fe",
    name: "Iron",
    category: "transition metal",
    group: 8,
    period: 4,
    atomicMass: 55.845,
    briefDesc: "Most used metal, basis of steel"
  },
  {
    atomicNumber: 27,
    symbol: "Co",
    name: "Cobalt",
    category: "transition metal",
    group: 9,
    period: 4,
    atomicMass: 58.933194,
    briefDesc: "Hard, lustrous, silver-gray metal"
  },
  {
    atomicNumber: 28,
    symbol: "Ni",
    name: "Nickel",
    category: "transition metal",
    group: 10,
    period: 4,
    atomicMass: 58.6934,
    briefDesc: "Silvery metal used in coins, alloys"
  },
  {
    atomicNumber: 29,
    symbol: "Cu",
    name: "Copper",
    category: "transition metal",
    group: 11,
    period: 4,
    atomicMass: 63.546,
    briefDesc: "Reddish metal, excellent electrical conductor"
  },
  {
    atomicNumber: 30,
    symbol: "Zn",
    name: "Zinc",
    category: "transition metal",
    group: 12,
    period: 4,
    atomicMass: 65.38,
    briefDesc: "Bluish-silver metal used to galvanize steel"
  },
  {
    atomicNumber: 31,
    symbol: "Ga",
    name: "Gallium",
    category: "post-transition metal",
    group: 13,
    period: 4,
    atomicMass: 69.723,
    briefDesc: "Soft metal melting near room temp"
  },
  {
    atomicNumber: 32,
    symbol: "Ge",
    name: "Germanium",
    category: "metalloid",
    group: 14,
    period: 4,
    atomicMass: 72.63,
    briefDesc: "Grayish-white metalloid for semiconductors"
  },
  {
    atomicNumber: 33,
    symbol: "As",
    name: "Arsenic",
    category: "metalloid",
    group: 15,
    period: 4,
    atomicMass: 74.921595,
    briefDesc: "Poisonous metalloid with many allotropes"
  },
  {
    atomicNumber: 34,
    symbol: "Se",
    name: "Selenium",
    category: "nonmetal",
    group: 16,
    period: 4,
    atomicMass: 78.971,
    briefDesc: "Nonmetal used in photocopiers, glass"
  },
  {
    atomicNumber: 35,
    symbol: "Br",
    name: "Bromine",
    category: "halogen",
    group: 17,
    period: 4,
    atomicMass: 79.904,
    briefDesc: "Reddish-brown liquid halogen"
  },
  {
    atomicNumber: 36,
    symbol: "Kr",
    name: "Krypton",
    category: "noble gas",
    group: 18,
    period: 4,
    atomicMass: 83.798,
    briefDesc: "Colorless noble gas for lighting"
  },
  {
    atomicNumber: 37,
    symbol: "Rb",
    name: "Rubidium",
    category: "alkali metal",
    group: 1,
    period: 5,
    atomicMass: 85.4678,
    briefDesc: "Very soft, highly reactive metal"
  },
  {
    atomicNumber: 38,
    symbol: "Sr",
    name: "Strontium",
    category: "alkaline earth metal",
    group: 2,
    period: 5,
    atomicMass: 87.62,
    briefDesc: "Silvery metal used in red fireworks"
  },
  {
    atomicNumber: 39,
    symbol: "Y",
    name: "Yttrium",
    category: "transition metal",
    group: 3,
    period: 5,
    atomicMass: 88.90584,
    briefDesc: "Silvery metal used in phosphors"
  },
  {
    atomicNumber: 40,
    symbol: "Zr",
    name: "Zirconium",
    category: "transition metal",
    group: 4,
    period: 5,
    atomicMass: 91.224,
    briefDesc: "Corrosion-resistant metal for nuclear reactors"
  },
  {
    atomicNumber: 41,
    symbol: "Nb",
    name: "Niobium",
    category: "transition metal",
    group: 5,
    period: 5,
    atomicMass: 92.90637,
    briefDesc: "Used in superconducting materials"
  },
  {
    atomicNumber: 42,
    symbol: "Mo",
    name: "Molybdenum",
    category: "transition metal",
    group: 6,
    period: 5,
    atomicMass: 95.95,
    briefDesc: "Hard, silvery metal for steel alloys"
  },
  {
    atomicNumber: 43,
    symbol: "Tc",
    name: "Technetium",
    category: "transition metal",
    group: 7,
    period: 5,
    atomicMass: 98,
    briefDesc: "Radioactive, first artificially made element"
  },
  {
    atomicNumber: 44,
    symbol: "Ru",
    name: "Ruthenium",
    category: "transition metal",
    group: 8,
    period: 5,
    atomicMass: 101.07,
    briefDesc: "Hard, silvery-white transition metal"
  },
  {
    atomicNumber: 45,
    symbol: "Rh",
    name: "Rhodium",
    category: "transition metal",
    group: 9,
    period: 5,
    atomicMass: 102.90550,
    briefDesc: "Highly reflective metal, used in plating"
  },
  {
    atomicNumber: 46,
    symbol: "Pd",
    name: "Palladium",
    category: "transition metal",
    group: 10,
    period: 5,
    atomicMass: 106.42,
    briefDesc: "Rare, lustrous metal in catalytic converters"
  },
  {
    atomicNumber: 47,
    symbol: "Ag",
    name: "Silver",
    category: "transition metal",
    group: 11,
    period: 5,
    atomicMass: 107.8682,
    briefDesc: "Best electrical conductor, lustrous"
  },
  {
    atomicNumber: 48,
    symbol: "Cd",
    name: "Cadmium",
    category: "transition metal",
    group: 12,
    period: 5,
    atomicMass: 112.414,
    briefDesc: "Bluish-white metal, toxic"
  },
  {
    atomicNumber: 49,
    symbol: "In",
    name: "Indium",
    category: "post-transition metal",
    group: 13,
    period: 5,
    atomicMass: 114.818,
    briefDesc: "Soft, malleable, used in LCDs"
  },
  {
    atomicNumber: 50,
    symbol: "Sn",
    name: "Tin",
    category: "post-transition metal",
    group: 14,
    period: 5,
    atomicMass: 118.71,
    briefDesc: "Silvery metal historically used in cans"
  },
  {
    atomicNumber: 51,
    symbol: "Sb",
    name: "Antimony",
    category: "metalloid",
    group: 15,
    period: 5,
    atomicMass: 121.76,
    briefDesc: "Brittle metalloid used in flame retardants"
  },
  {
    atomicNumber: 52,
    symbol: "Te",
    name: "Tellurium",
    category: "metalloid",
    group: 16,
    period: 5,
    atomicMass: 127.6,
    briefDesc: "Brittle, silvery metalloid in semiconductors"
  },
  {
    atomicNumber: 53,
    symbol: "I",
    name: "Iodine",
    category: "halogen",
    group: 17,
    period: 5,
    atomicMass: 126.90447,
    briefDesc: "Purple-black solid halogen, essential nutrient"
  },
  {
    atomicNumber: 54,
    symbol: "Xe",
    name: "Xenon",
    category: "noble gas",
    group: 18,
    period: 5,
    atomicMass: 131.293,
    briefDesc: "Heavy, colorless noble gas, used in flash lamps"
  },
  {
    atomicNumber: 55,
    symbol: "Cs",
    name: "Cesium",
    category: "alkali metal",
    group: 1,
    period: 6,
    atomicMass: 132.90545196,
    briefDesc: "Soft, golden metal, highly reactive"
  },
  {
    atomicNumber: 56,
    symbol: "Ba",
    name: "Barium",
    category: "alkaline earth metal",
    group: 2,
    period: 6,
    atomicMass: 137.327,
    briefDesc: "Silvery metal used in X-ray contrast agents"
  },
  {
    atomicNumber: 57,
    symbol: "La",
    name: "Lanthanum",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 138.90547,
    briefDesc: "Soft, ductile metal, starts lanthanide series"
  },
  {
    atomicNumber: 58,
    symbol: "Ce",
    name: "Cerium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 140.116,
    briefDesc: "Most abundant lanthanide, used in converters"
  },
  {
    atomicNumber: 59,
    symbol: "Pr",
    name: "Praseodymium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 140.90766,
    briefDesc: "Soft, silvery lanthanide used in magnets"
  },
  {
    atomicNumber: 60,
    symbol: "Nd",
    name: "Neodymium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 144.242,
    briefDesc: "Used in powerful rare-earth magnets"
  },
  {
    atomicNumber: 61,
    symbol: "Pm",
    name: "Promethium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 145,
    briefDesc: "Radioactive, no stable isotopes"
  },
  {
    atomicNumber: 62,
    symbol: "Sm",
    name: "Samarium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 150.36,
    briefDesc: "Used in magnets and nuclear reactors"
  },
  {
    atomicNumber: 63,
    symbol: "Eu",
    name: "Europium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 151.964,
    briefDesc: "Most reactive lanthanide, used in phosphors"
  },
  {
    atomicNumber: 64,
    symbol: "Gd",
    name: "Gadolinium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 157.25,
    briefDesc: "Used in MRI contrast, has special magnetic properties"
  },
  {
    atomicNumber: 65,
    symbol: "Tb",
    name: "Terbium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 158.925354,
    briefDesc: "Used in green phosphors & devices"
  },
  {
    atomicNumber: 66,
    symbol: "Dy",
    name: "Dysprosium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 162.5,
    briefDesc: "Silvery metal for lasers, magnets"
  },
  {
    atomicNumber: 67,
    symbol: "Ho",
    name: "Holmium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 164.930328,
    briefDesc: "Used in nuclear reactors & special alloys"
  },
  {
    atomicNumber: 68,
    symbol: "Er",
    name: "Erbium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 167.259,
    briefDesc: "Used in optical fibers & amplifiers"
  },
  {
    atomicNumber: 69,
    symbol: "Tm",
    name: "Thulium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 168.934218,
    briefDesc: "Rare, used in some lasers"
  },
  {
    atomicNumber: 70,
    symbol: "Yb",
    name: "Ytterbium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 173.045,
    briefDesc: "Soft, silvery metal used in some steels"
  },
  {
    atomicNumber: 71,
    symbol: "Lu",
    name: "Lutetium",
    category: "lanthanide",
    group: 3,
    period: 6,
    atomicMass: 174.9668,
    briefDesc: "Hard, silvery-white metal, end of lanthanides"
  },
  {
    atomicNumber: 72,
    symbol: "Hf",
    name: "Hafnium",
    category: "transition metal",
    group: 4,
    period: 6,
    atomicMass: 178.49,
    briefDesc: "Used in nuclear control rods, very corrosion-resistant"
  },
  {
    atomicNumber: 73,
    symbol: "Ta",
    name: "Tantalum",
    category: "transition metal",
    group: 5,
    period: 6,
    atomicMass: 180.94788,
    briefDesc: "Blue-gray metal, highly corrosion-resistant"
  },
  {
    atomicNumber: 74,
    symbol: "W",
    name: "Tungsten",
    category: "transition metal",
    group: 6,
    period: 6,
    atomicMass: 183.84,
    briefDesc: "Highest melting point of all elements"
  },
  {
    atomicNumber: 75,
    symbol: "Re",
    name: "Rhenium",
    category: "transition metal",
    group: 7,
    period: 6,
    atomicMass: 186.207,
    briefDesc: "Rare metal used in superalloys"
  },
  {
    atomicNumber: 76,
    symbol: "Os",
    name: "Osmium",
    category: "transition metal",
    group: 8,
    period: 6,
    atomicMass: 190.23,
    briefDesc: "Densest naturally occurring element"
  },
  {
    atomicNumber: 77,
    symbol: "Ir",
    name: "Iridium",
    category: "transition metal",
    group: 9,
    period: 6,
    atomicMass: 192.217,
    briefDesc: "Very hard, brittle metal with high melting point"
  },
  {
    atomicNumber: 78,
    symbol: "Pt",
    name: "Platinum",
    category: "transition metal",
    group: 10,
    period: 6,
    atomicMass: 195.084,
    briefDesc: "Precious, dense, malleable metal for catalysts"
  },
  {
    atomicNumber: 79,
    symbol: "Au",
    name: "Gold",
    category: "transition metal",
    group: 11,
    period: 6,
    atomicMass: 196.966569,
    briefDesc: "Soft, yellow metal, highly valued precious metal"
  },
  {
    atomicNumber: 80,
    symbol: "Hg",
    name: "Mercury",
    category: "transition metal",
    group: 12,
    period: 6,
    atomicMass: 200.592,
    briefDesc: "Silvery metal, liquid at room temperature"
  },
  {
    atomicNumber: 81,
    symbol: "Tl",
    name: "Thallium",
    category: "post-transition metal",
    group: 13,
    period: 6,
    atomicMass: 204.38,
    briefDesc: "Soft, gray metal, highly toxic"
  },
  {
    atomicNumber: 82,
    symbol: "Pb",
    name: "Lead",
    category: "post-transition metal",
    group: 14,
    period: 6,
    atomicMass: 207.2,
    briefDesc: "Soft, malleable metal used in batteries"
  },
  {
    atomicNumber: 83,
    symbol: "Bi",
    name: "Bismuth",
    category: "post-transition metal",
    group: 15,
    period: 6,
    atomicMass: 208.98040,
    briefDesc: "Brittle metal, low toxicity, used in meds"
  },
  {
    atomicNumber: 84,
    symbol: "Po",
    name: "Polonium",
    category: "metalloid",
    group: 16,
    period: 6,
    atomicMass: 209,
    briefDesc: "Radioactive metalloid discovered by Curie"
  },
  {
    atomicNumber: 85,
    symbol: "At",
    name: "Astatine",
    category: "halogen",
    group: 17,
    period: 6,
    atomicMass: 210,
    briefDesc: "Rare, radioactive halogen"
  },
  {
    atomicNumber: 86,
    symbol: "Rn",
    name: "Radon",
    category: "noble gas",
    group: 18,
    period: 6,
    atomicMass: 222,
    briefDesc: "Radioactive, colorless noble gas"
  },
  {
    atomicNumber: 87,
    symbol: "Fr",
    name: "Francium",
    category: "alkali metal",
    group: 1,
    period: 7,
    atomicMass: 223,
    briefDesc: "Extremely reactive, radioactive alkali metal"
  },
  {
    atomicNumber: 88,
    symbol: "Ra",
    name: "Radium",
    category: "alkaline earth metal",
    group: 2,
    period: 7,
    atomicMass: 226,
    briefDesc: "Radioactive, glows faintly in the dark"
  },
  {
    atomicNumber: 89,
    symbol: "Ac",
    name: "Actinium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 227,
    briefDesc: "Radioactive, starts the actinide series"
  },
  {
    atomicNumber: 90,
    symbol: "Th",
    name: "Thorium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 232.0377,
    briefDesc: "Potential nuclear fuel, slightly radioactive"
  },
  {
    atomicNumber: 91,
    symbol: "Pa",
    name: "Protactinium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 231.03588,
    briefDesc: "Rare, radioactive actinide"
  },
  {
    atomicNumber: 92,
    symbol: "U",
    name: "Uranium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 238.02891,
    briefDesc: "Radioactive, used in nuclear power & weapons"
  },
  {
    atomicNumber: 93,
    symbol: "Np",
    name: "Neptunium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 237,
    briefDesc: "Transuranic, radioactive actinide"
  },
  {
    atomicNumber: 94,
    symbol: "Pu",
    name: "Plutonium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 244,
    briefDesc: "Transuranic, radioactive, used in nuclear bombs"
  },
  {
    atomicNumber: 95,
    symbol: "Am",
    name: "Americium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 243,
    briefDesc: "Radioactive, used in smoke detectors"
  },
  {
    atomicNumber: 96,
    symbol: "Cm",
    name: "Curium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 247,
    briefDesc: "Transuranic, radioactive metal"
  },
  {
    atomicNumber: 97,
    symbol: "Bk",
    name: "Berkelium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 247,
    briefDesc: "Transuranic, synthetic radioactive actinide"
  },
  {
    atomicNumber: 98,
    symbol: "Cf",
    name: "Californium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 251,
    briefDesc: "Transuranic, used to start nuclear reactors"
  },
  {
    atomicNumber: 99,
    symbol: "Es",
    name: "Einsteinium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 252,
    briefDesc: "Synthetic, radioactive metal"
  },
  {
    atomicNumber: 100,
    symbol: "Fm",
    name: "Fermium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 257,
    briefDesc: "Synthetic, radioactive actinide"
  },
  {
    atomicNumber: 101,
    symbol: "Md",
    name: "Mendelevium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 258,
    briefDesc: "Synthetic, radioactive actinide"
  },
  {
    atomicNumber: 102,
    symbol: "No",
    name: "Nobelium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 259,
    briefDesc: "Synthetic, radioactive actinide"
  },
  {
    atomicNumber: 103,
    symbol: "Lr",
    name: "Lawrencium",
    category: "actinide",
    group: 3,
    period: 7,
    atomicMass: 266,
    briefDesc: "Synthetic, radioactive metal"
  },
  {
    atomicNumber: 104,
    symbol: "Rf",
    name: "Rutherfordium",
    category: "transition metal",
    group: 4,
    period: 7,
    atomicMass: 267,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 105,
    symbol: "Db",
    name: "Dubnium",
    category: "transition metal",
    group: 5,
    period: 7,
    atomicMass: 268,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 106,
    symbol: "Sg",
    name: "Seaborgium",
    category: "transition metal",
    group: 6,
    period: 7,
    atomicMass: 269,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 107,
    symbol: "Bh",
    name: "Bohrium",
    category: "transition metal",
    group: 7,
    period: 7,
    atomicMass: 270,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 108,
    symbol: "Hs",
    name: "Hassium",
    category: "transition metal",
    group: 8,
    period: 7,
    atomicMass: 269,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 109,
    symbol: "Mt",
    name: "Meitnerium",
    category: "transition metal",
    group: 9,
    period: 7,
    atomicMass: 278,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 110,
    symbol: "Ds",
    name: "Darmstadtium",
    category: "transition metal",
    group: 10,
    period: 7,
    atomicMass: 281,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 111,
    symbol: "Rg",
    name: "Roentgenium",
    category: "transition metal",
    group: 11,
    period: 7,
    atomicMass: 282,
    briefDesc: "Synthetic, radioactive transition metal"
  },
  {
    atomicNumber: 112,
    symbol: "Cn",
    name: "Copernicium",
    category: "post-transition metal",
    group: 12,
    period: 7,
    atomicMass: 285,
    briefDesc: "Synthetic, radioactive post-transition metal"
  },
  {
    atomicNumber: 113,
    symbol: "Nh",
    name: "Nihonium",
    category: "post-transition metal",
    group: 13,
    period: 7,
    atomicMass: 286,
    briefDesc: "Synthetic, radioactive post-transition metal"
  },
  {
    atomicNumber: 114,
    symbol: "Fl",
    name: "Flerovium",
    category: "post-transition metal",
    group: 14,
    period: 7,
    atomicMass: 289,
    briefDesc: "Synthetic, radioactive post-transition metal"
  },
  {
    atomicNumber: 115,
    symbol: "Mc",
    name: "Moscovium",
    category: "post-transition metal",
    group: 15,
    period: 7,
    atomicMass: 289,
    briefDesc: "Synthetic, radioactive post-transition metal"
  },
  {
    atomicNumber: 116,
    symbol: "Lv",
    name: "Livermorium",
    category: "post-transition metal",
    group: 16,
    period: 7,
    atomicMass: 293,
    briefDesc: "Synthetic, radioactive post-transition metal"
  },
  {
    atomicNumber: 117,
    symbol: "Ts",
    name: "Tennessine",
    category: "halogen",
    group: 17,
    period: 7,
    atomicMass: 294,
    briefDesc: "Synthetic, radioactive halogen"
  },
  {
    atomicNumber: 118,
    symbol: "Og",
    name: "Oganesson",
    category: "noble gas",
    group: 18,
    period: 7,
    atomicMass: 294,
    briefDesc: "Synthetic, heaviest noble gas known"
  }
];
