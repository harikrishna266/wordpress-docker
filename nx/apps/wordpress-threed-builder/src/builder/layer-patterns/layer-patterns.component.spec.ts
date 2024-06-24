import { ComponentFixture, TestBed } from '@angular/core/testing';
import { LayerPatternsComponent } from './layer-patterns.component';

describe('LayerPatternsComponent', () => {
  let component: LayerPatternsComponent;
  let fixture: ComponentFixture<LayerPatternsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [LayerPatternsComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(LayerPatternsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
