import { Layer } from './layer.type';
import { Path } from '@brocha-libs/builder-2d/lib/shapes/path';

export type DesignLayer = { layer: Layer, path: Path, type: 'layer'};
export type PatternLayer = { layer: Layer, path: Path, pattern: Path, type: 'pattern', enabled: boolean};
export type LayerTypes = PatternLayer | DesignLayer ;
