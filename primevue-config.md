PrimeVue config task
- Create and configure proper primevue config to ensure that the primevue components use the appropriate theme for this project.
- Attached below with a sample for the primevue config from another project of mine (usePrimeVue.js file), create and configure a primevue config file in this repo with neutral colors

import Aura from '@primeuix/themes/aura';
import { definePreset } from '@primeuix/themes';

export const DdacPreset = definePreset(Aura, {
  semantic: {
    primary: {
      50: '#EFF6FF',
      100: '#E7EDFA',
      200: '#92B9CB',
      300: '#03609C',
      400: '#172747',
      500: '#0C2747',
      600: '#081C36',
      700: '#07172E',
      800: '#061325',
      900: '#0A1A2E',
      950: '#050B14',
    },
    colorScheme: {
      light: {
        primary: {
          color: '#03609C',
          inverseColor: '#EFF6FF',
          hoverColor: '#92B9CB',
          activeColor: '#92B9CB'
        },
        highlight: {
          background: '#03609C',
          focusBackground: '#92b9cb',
          color: '#EFF6FF',
          focusColor: '#EFF6FF'
        },
        surface: {
          0: '#e7edfa',
          50: '#fcfaf5',
          100: '#92b9cb66',
          200: '#92b9cb',
          300: '#b0b0b0',
          400: '#4c4942',
          500: '#33322e',
          600: '#333333',
          700: '#333333',
          800: '#333333',
          900: '#333333',
          950: '#333333'
        }
      },
      dark: {
        primary: {
          color: '#f36240',
          inverseColor: '#461509',
          hoverColor: '#fb896e',
          activeColor: '#feb4a3'
        },
        highlight: {
          background: 'rgba(227, 70, 34, 0.16)',
          focusBackground: 'rgba(227, 70, 34, 0.24)',
          color: 'rgba(255,255,255,.87)',
          focusColor: 'rgba(255,255,255,.87)'
        },
        surface: {
          0: '#33322e',
          50: '#4c4942',
          100: '#333333',
          200: '#b0b0b0',
          300: '#ddc594',
          400: '#f4f1e9',
          500: '#fcfaf5',
          600: '#ffffff',
          700: '#ffffff',
          800: '#ffffff',
          900: '#ffffff',
          950: '#ffffff'
        }
      }
    }
  },
  components: {
    button: {
      root: {
        borderRadius: '32px',
        paddingX: '1.25rem',
        paddingY: '0.65rem'
      },
      colorScheme: {
        light: {
          primary: {
            background: '#03609C',
            hoverBackground: '#92B9CB',
            activeBackground: '#92B9CB',
            borderColor: '#03609C',
            hoverBorderColor: '#92B9CB',
            color: '#EFF6FF',
            hoverColor: '#25252E',
            activeColor: '#25252E'
          },
          secondary: {
            background: '#7db746',
            hoverBackground: '#72a53c',
            activeBackground: '#72a53c',
            borderColor: '#7db746',
            hoverBorderColor: '#72a53c',
            color: '#ffffff',
            hoverColor: '#ffffff',
            activeColor: '#ffffff'
          }
        }
      }
    },
    togglebutton: {
      root: {
        checked: { background: 'rgb(146 185 203 / 0.4)' },
      }
    },
    card: {
      root: {
        borderRadius: '12px',
      },
      body: {
        height: '100%'
      },
      colorScheme: {
        light: {
          root: {
            background: '#dbe4f7',
            color: '#2B2B35'
          },
          subtitle: {
            color: '#4B5563'
          }
        }
      }
    },
    inputtext: {
      root: {
        borderRadius: '8px',
        background: '#ffffff',
        disabledBackground: undefined,
        paddingX: '0.75rem',
        paddingY: '0.625rem',
        borderColor: '#03609C',
        hoverBorderColor: '#92B9CB',
        focusBorderColor: '#92B9CB',
      },
    },
    dialog: {
      root: {
        borderRadius: '12px',
        background: '#E7EDFA',
      }
    },
    toast: {
      root: {
        borderRadius: '8px'
      }
    },
    fontSize: {
      "heading-1": ["48px", "1.2"],
      "heading-2": ["40px", "1.2"],
      "heading-3": ["36px", "1.2"],
      "heading-4": ["24px", "1.3"],
      "heading-5": ["18px", "1.3"],
      "heading-6": ["14px", "1.4"],
      "body-large": ["18px", "1.5"],
      "body-medium": ["14px", "1.5"],
      "body-small": ["12px", "1.5"],
      "tag-medium": ["14px", "1.4"],
      "tag-small": ["12px", "1.5"],
    },
  },
});

