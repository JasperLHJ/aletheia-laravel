import Aura from '@primeuix/themes/aura';
import { definePreset } from '@primeuix/themes';

/**
 * CMS preset: ~60% neutral surfaces, blue accent (~10%) for actions and focus.
 * Dark mode uses soft charcoal backgrounds (no pure black).
 */
export const NeutralPreset = definePreset(Aura, {
  semantic: {
    primary: {
      50: '#eff6ff',
      100: '#dbeafe',
      200: '#bfdbfe',
      300: '#93c5fd',
      400: '#60a5fa',
      500: '#3b82f6',
      600: '#2563eb',
      700: '#1d4ed8',
      800: '#1e40af',
      900: '#1e3a8a',
      950: '#172554',
    },
    green: {
      50: '#f0fdf4',
      100: '#dcfce7',
      200: '#bbf7d0',
      300: '#86efac',
      400: '#4ade80',
      500: '#22c55e',
      600: '#16a34a',
      700: '#15803d',
      800: '#166534',
      900: '#14532d',
      950: '#052e16',
    },
    red: {
      50: '#fef2f2',
      100: '#fee2e2',
      200: '#fecaca',
      300: '#fca5a5',
      400: '#f87171',
      500: '#ef4444',
      600: '#dc2626',
      700: '#b91c1c',
      800: '#991b1b',
      900: '#7f1d1d',
      950: '#450a0a',
    },
    orange: {
      50: '#fffbeb',
      100: '#fef3c7',
      200: '#fde68a',
      300: '#fcd34d',
      400: '#fbbf24',
      500: '#f59e0b',
      600: '#d97706',
      700: '#b45309',
      800: '#92400e',
      900: '#78350f',
      950: '#451a03',
    },
    colorScheme: {
      light: {
        primary: {
          color: '{primary.600}',
          inverseColor: '#ffffff',
          hoverColor: '{primary.700}',
          activeColor: '{primary.800}',
        },
        highlight: {
          background: '{primary.600}',
          focusBackground: '{primary.700}',
          color: '#ffffff',
          focusColor: '#ffffff',
        },
        surface: {
          0: '#ffffff',
          50: '#f4f6f9',
          100: '#eef1f6',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: '#0f172a',
          950: '#020617',
        },
      },
      dark: {
        primary: {
          color: '{primary.400}',
          inverseColor: '{primary.950}',
          hoverColor: '{primary.300}',
          activeColor: '{primary.200}',
        },
        highlight: {
          background: 'color-mix(in srgb, {primary.400}, transparent 84%)',
          focusBackground: 'color-mix(in srgb, {primary.400}, transparent 72%)',
          color: 'rgba(255, 255, 255, 0.92)',
          focusColor: 'rgba(255, 255, 255, 0.92)',
        },
        surface: {
          0: '#1e1e1e',
          50: '#252525',
          100: '#2d2d2d',
          200: '#3a3a3a',
          300: '#4a4a4a',
          400: '#6b6b6b',
          500: '#8a8a8a',
          600: '#a8a8a8',
          700: '#c4c4c4',
          800: '#e0e0e0',
          900: '#f0f0f0',
          950: '#fafafa',
        },
        /**
         * Aura maps text.color → {surface.0} and content.background → {surface.900} in dark mode.
         * Our surface scale is “0 = darkest”, so those defaults yield dark-on-dark text and light rows.
         */
        text: {
          color: 'rgba(255, 255, 255, 0.92)',
          hoverColor: '#ffffff',
          mutedColor: '{surface.500}',
          hoverMutedColor: '{surface.400}',
        },
        content: {
          background: '{surface.50}',
          hoverBackground: '{surface.100}',
          borderColor: '{surface.200}',
          color: 'rgba(255, 255, 255, 0.92)',
          hoverColor: '#ffffff',
        },
      },
    },
  },
  components: {
    button: {
      root: {
        borderRadius: '10px',
        paddingX: '1.35rem',
        paddingY: '0.7rem',
      },
      colorScheme: {
        light: {
          primary: {
            background: '{primary.600}',
            hoverBackground: '{primary.700}',
            activeBackground: '{primary.800}',
            borderColor: '{primary.600}',
            hoverBorderColor: '{primary.700}',
            color: '#ffffff',
            hoverColor: '#ffffff',
            activeColor: '#ffffff',
          },
          secondary: {
            background: '{surface.100}',
            hoverBackground: '{surface.200}',
            activeBackground: '{surface.300}',
            borderColor: '{surface.200}',
            hoverBorderColor: '{surface.300}',
            color: '{surface.700}',
            hoverColor: '{surface.800}',
            activeColor: '{surface.900}',
          },
        },
        dark: {
          primary: {
            background: '{primary.500}',
            hoverBackground: '{primary.400}',
            activeBackground: '{primary.300}',
            borderColor: '{primary.500}',
            hoverBorderColor: '{primary.400}',
            color: '{primary.950}',
            hoverColor: '{primary.950}',
            activeColor: '{primary.950}',
          },
          secondary: {
            background: '{surface.100}',
            hoverBackground: '{surface.200}',
            activeBackground: '{surface.300}',
            borderColor: '{surface.200}',
            hoverBorderColor: '{surface.300}',
            color: '{surface.900}',
            hoverColor: '{surface.950}',
            activeColor: '#ffffff',
          },
        },
      },
    },
    togglebutton: {
      root: {
        checked: { background: 'rgb(37 99 235 / 0.25)' },
      },
    },
    card: {
      root: {
        borderRadius: '14px',
        shadow: '0 1px 3px 0 rgb(0 0 0 / 0.06), 0 1px 2px -1px rgb(0 0 0 / 0.06)',
      },
      body: {
        padding: '1.5rem',
        height: '100%',
      },
      colorScheme: {
        light: {
          root: {
            background: '{surface.0}',
            color: '{surface.900}',
          },
          subtitle: {
            color: '{surface.500}',
          },
        },
        dark: {
          root: {
            background: '{surface.50}',
            color: '{surface.900}',
          },
          subtitle: {
            color: '{surface.600}',
          },
        },
      },
    },
    inputtext: {
      root: {
        borderRadius: '10px',
        background: '{surface.0}',
        disabledBackground: undefined,
        paddingX: '0.875rem',
        paddingY: '0.7rem',
        borderColor: '{surface.200}',
        hoverBorderColor: '{surface.400}',
        focusBorderColor: '{primary.500}',
      },
    },
    textarea: {
      root: {
        borderRadius: '10px',
        paddingX: '0.875rem',
        paddingY: '0.7rem',
      },
    },
    select: {
      root: {
        borderRadius: '10px',
      },
    },
    dialog: {
      root: {
        borderRadius: '14px',
        background: '{surface.0}',
      },
    },
    toast: {
      root: {
        borderRadius: '10px',
      },
    },
    tag: {
      colorScheme: {
        light: {
          success: {
            background: '{green.100}',
            color: '{green.800}',
          },
          warn: {
            background: '{orange.100}',
            color: '{orange.800}',
          },
          danger: {
            background: '{red.100}',
            color: '{red.800}',
          },
        },
        dark: {
          success: {
            background: 'color-mix(in srgb, {green.500}, transparent 82%)',
            color: '{green.300}',
          },
          warn: {
            background: 'color-mix(in srgb, {orange.500}, transparent 82%)',
            color: '{orange.300}',
          },
          danger: {
            background: 'color-mix(in srgb, {red.500}, transparent 82%)',
            color: '{red.300}',
          },
        },
      },
    },
    datatable: {
      headerCell: {
        padding: '1rem 1.15rem',
      },
      bodyCell: {
        padding: '1rem 1.15rem',
      },
      colorScheme: {
        dark: {
          root: {
            borderColor: '{surface.200}',
          },
          row: {
            stripedBackground: 'color-mix(in srgb, #ffffff 4.5%, {surface.50})',
          },
          bodyCell: {
            selectedBorderColor: '{primary.400}',
          },
        },
      },
    },
    fontSize: {
      'heading-1': ['48px', '1.2'],
      'heading-2': ['40px', '1.2'],
      'heading-3': ['36px', '1.2'],
      'heading-4': ['24px', '1.3'],
      'heading-5': ['18px', '1.3'],
      'heading-6': ['14px', '1.4'],
      'body-large': ['18px', '1.5'],
      'body-medium': ['14px', '1.5'],
      'body-small': ['12px', '1.5'],
      'tag-medium': ['14px', '1.4'],
      'tag-small': ['12px', '1.5'],
    },
  },
});
